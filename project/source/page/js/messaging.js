import { linkify } from "./linkify.js";

var messagesById = {};
var messagesByFrom = {};
var latestIssuedRequestId = undefined;
var localeStrings = {
  'time': {hour: 'numeric', minute: '2-digit'},
  'in the past week': {weekday: 'long'},
  'this year': {month: 'short', day: 'numeric'},
  'past date': {month: 'numeric', day: 'numeric', year: '2-digit'},
};

function getRelativeType(date) {
  const currentDate = new Date();
  const sentToday = !(date.getDate() < currentDate.getDate() || date.getMonth() < currentDate.getMonth() || date.getYear() < currentDate.getYear());
  const sentThisWeek = date > new Date(currentDate).setDate(currentDate.getDate() - 6); // Could technically be - 7, but this way avoids same-day confusion
  const sentThisYear = date.getYear() == currentDate.getYear();
  if (sentToday) return "TODAY";
  if (sentThisWeek) return "THIS_WEEK";
  if (sentThisYear) return "THIS_YEAR";
  return undefined;
}

function getRelativeRepresentation(date) {
  switch (getRelativeType(date)) {
    case ("TODAY"): return "Today";
    case ("THIS_WEEK"): return date.toLocaleString(undefined, localeStrings['in the past week']);
    case ("THIS_YEAR"): return date.toLocaleString(undefined, localeStrings['this year']);
    default: return date.toLocaleString(undefined, localeStrings['past date']);
  }
}

function toMessageContentString(msg) {
  const sentDate = new Date(msg['sent_time']);
  const dateOutput = function() {
    switch(getRelativeType(sentDate)) {
      case ("TODAY"): return "";
      case ("THIS_WEEK"): return `${getRelativeRepresentation(sentDate)} at `;
      default: return `<span class='muted'>${getRelativeRepresentation(sentDate)}</span> `;
    }
  }();
  const timeOutput = function() {
    let time = new Date(msg['sent_time']).toLocaleString(undefined, localeStrings['time']);
    if (getRelativeType(sentDate) == "TODAY") {
      time = `<strong>${time}</strong>`;
    }
    return time;
  }();
  function wrapMessageInContainer(timestamp, message) {
    return `<div class='${msg['is_sender'] ? 'sent-message' : 'received-message'}'><p${msg['unread'] ? " class='unread"+(msg['unsent'] ? " unsent" : "")+"'" : ""}><span ${!msg['unread'] && msg['is_sender'] ? "title='Seen'" : ""} class='right message-time-sent'>${timestamp}</span>${message}</p></div>`
  }
  return wrapMessageInContainer(`${dateOutput}${timeOutput}`, linkify(msg['message']));
}

function sendAlertEmail() {
  let rq = new XMLHttpRequest();
  rq.open("POST", "/action/send-message-alert-email", true);
  rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  rq.send();
}

function sendMessage() {
  let message = document.querySelector('.message-entry').value;
  document.querySelector('.message-entry').value = "";
  document.querySelector('.message-entry').setAttribute("placeholder", "Sending…");
  let conversationPartner = document.querySelector('.message-chooser-message.selected').getAttribute('conversation');
  let selectedMessageBody = document.querySelector('.message-chooser-message.selected .last-message-body');
  let rq = new XMLHttpRequest();
  rq.open("POST", "/action/submit-messaging-message", true);
  const params = {
    "to": conversationPartner,
    "message": message
  };
  rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  rq.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      delete messagesByFrom[parseInt(conversationPartner)];
      getMessages(parseInt(conversationPartner), messagesByFrom, "/action/get-messages?from=");
      
      sendAlertEmail();
    }
  }
  rq.send(Object.entries(params).map(pair => pair[0] + "=" + pair[1]).join("&"));
  
  let node = document.createElement("em");
  node.textContent = message;
  selectedMessageBody.replaceChildren(node);
  
  document.querySelector('.message-chooser-message.selected .last-message-time').textContent = new Date().toLocaleString(undefined, localeStrings['time']);
  
  document.querySelector('.message-content').innerHTML += toMessageContentString(
    {
      'unsent': true,
      'unread': true,
      'is_sender': true,
      'sent_time': new Date(),
      'message': message
    }
  );
  
  let viewer = document.querySelector('.message-viewer');
  viewer.scrollTop = viewer.scrollHeight;
}

function setContent(replyable, ...messageData) {
  getUpdates();
  let content = "";
  let lastDate = new Date(0);
  messageData.forEach(function(msg) {
    const thisDate = new Date(msg['sent_time']);
    if (thisDate.toLocaleDateString() != lastDate.toLocaleDateString()) {
      content += `<div class=message-date-separator><p>${getRelativeRepresentation(thisDate)}</p></div>`;
      lastDate = thisDate;
    }
    content += toMessageContentString(msg);
  });
  document.querySelector('.message-content').classList.remove('old-content');
  document.querySelector('.message-content').innerHTML = content;
  document.querySelector('.message-chooser-message.selected').classList.remove('unread');
  
  let messageFormHTML = `<input disabled type="text" class="message-entry" placeholder="You cannot reply to guests."></input>`;
  if (replyable) {
    let messageEntry = `<input class="message-entry" type="text" placeholder="Type a message…" minlength="1" required></input>`;
    let sendButton = `<button type="submit" class="send-button" title="Send">➤</button>`
    messageFormHTML = messageEntry + sendButton;
  }
  document.getElementById('message-form').innerHTML = messageFormHTML;
  document.getElementById('message-form').onsubmit = function(e) {
    sendMessage();
    e.preventDefault();
  };
  document.querySelector('.message-entry').focus();
}

function getUpdates() {
  function updateUnreadCount() {
    let rq = new XMLHttpRequest();
    rq.open("POST", "/action/get-unread-count", true);
    rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    rq.onreadystatechange = function() {
      if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
        document.querySelectorAll('.check-messages').forEach(function(p) {
          if (rq.responseText == 0) {
            p.querySelector('.notification-dot')?.remove();
            return;
          }
          if (p.querySelector('.notification-dot')) {
            p.querySelector('.notification-dot').textContent = rq.responseText;
          } else {
            let node = document.createElement("span");
            node.classList.add("notification-dot");
            node.textContent = rq.responseText;
            p.appendChild(node);
          }
        });
        
        getUpdates.updatesRemaining -= 1;
      }
    }
    rq.send();
  }
  
  function updatePreviews() {
    let rq = new XMLHttpRequest();
    rq.open("POST", "/action/show-message-previews", true);
    rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    rq.onreadystatechange = function() {
      if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
        let selected = document.querySelector('.message-chooser-message.selected');
        let selectedAttribute = selected.getAttribute('conversation') ? 'conversation' : 'last-message';
        let selectedValue = selected.getAttribute('conversation') ?? selected.getAttribute('last-message');
        document.querySelector('.message-chooser').innerHTML = rq.responseText;
        document.querySelector('.message-chooser-message['+selectedAttribute+'="'+selectedValue+'"]').classList.add('selected');
        wireMessageChooser();
        
        getUpdates.updatesRemaining -= 1;
      }
    }
    rq.send();
  }
  
  if (getUpdates.updatesRemaining) {
    return;
  }
  getUpdates.updatesRemaining = 2;
  updateUnreadCount();
  updatePreviews();
}

function getMessages(id, messageCache, uri) {
  let name = document.querySelector('.message-chooser-message.selected .conversation-partner').textContent;
  document.querySelector('.message-viewer > .conversation-partner').textContent = name;
  if (id in messageCache) {
    setContent(messageCache == messagesByFrom, ...messageCache[id]);
    return;
  }
  latestIssuedRequestId = id;
  let rq = new XMLHttpRequest();
  rq.open("GET", uri + id, true);
  rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  rq.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      clearTimeout(loading);
      messageCache[id] = JSON.parse(rq.responseText);
      if (latestIssuedRequestId == id) {
        getMessages(id, messageCache, uri);
      }
    }
  }
  let loading = setTimeout(function() {
    document.querySelector('.message-content').classList.remove('old-content');
    document.getElementById('message-form').innerHTML = '';
    document.querySelector('.message-content').innerHTML = `
<p class="center">Loading messages...</p>
<svg class="loading-animation" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: none; display: block; shape-rendering: auto;" width="100px" height="100px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
<circle cx="50" cy="50" fill="none" stroke="#a9b" stroke-width="8" r="40" stroke-dasharray="160">
  <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="0.8s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
</circle></svg>`;
  }, 500);
  rq.send();
}

function wireMessageChooser() {
  document.querySelectorAll('.message-chooser-message').forEach(message => {
    message.onclick = function() {
      document.querySelector('.message-chooser').classList.remove('visible-on-mobile');
      document.querySelector('.message-viewer').classList.add('visible-on-mobile');
      
      document.querySelector('.message-content').classList.add('old-content');
      
      document.querySelectorAll('.message-chooser-message').forEach(message => {
        message.classList.remove('selected');
      });
      message.classList.add('selected');
      
      let id = parseInt(message.getAttribute('conversation'));
      if (isNaN(id)) {
        id = parseInt(message.getAttribute('last-message'));
        getMessages(id, messagesById, "/action/get-message?id=");
      } else {
        getMessages(id, messagesByFrom, "/action/get-messages?from=");
      }
    }
  });
}

wireMessageChooser();
