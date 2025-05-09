import { linkify } from "./linkify.js";

const LOCALE = "en-CA";
const LOCALE_STRING_OPTIONS_TIME = {hour: 'numeric', minute: '2-digit'};
var messagesById = {};
var messagesByFrom = {};
var isLatestLoadedMessageFromToday = false;
sendMessage.pendingRefreshes = [];

function getSelectedId() {
  const selected = document.querySelector('.message-chooser-message.selected');
  return selected.getAttribute('conversation') ?? selected.getAttribute('last-message');
}

function getRelativeType(date) {
  const currentDate = new Date();
  const sentToday = !(date.getDate() < currentDate.getDate() || date.getMonth() < currentDate.getMonth() || date.getYear() < currentDate.getYear());
  const sentYesterday = date > new Date(new Date(currentDate).setHours(0, 0, 0, 0)).setDate(currentDate.getDate() - 1);
  const sentThisWeek = date > new Date(new Date(currentDate).setHours(0, 0, 0, 0)).setDate(currentDate.getDate() - currentDate.getDay());
  const sentThisYear = date.getYear() == currentDate.getYear();
  if (sentToday) return "TODAY";
  if (sentYesterday) return "YESTERDAY";
  if (sentThisWeek) return "THIS_WEEK";
  if (sentThisYear) return "THIS_YEAR";
  return undefined;
}

function getRelativeRepresentation(date, localeStringOptions = {
    'in the past week': {weekday: 'long'},
    'this year': {month: 'short', day: 'numeric'},
    'past date': {month: 'numeric', day: 'numeric', year: '2-digit'},
  }) {
  switch (getRelativeType(date)) {
    case ("TODAY"): return "Today";
    case ("YESTERDAY"): return "Yesterday";
    case ("THIS_WEEK"): return date.toLocaleString(LOCALE, localeStringOptions['in the past week']);
    case ("THIS_YEAR"): return date.toLocaleString(LOCALE, localeStringOptions['this year']);
    default: return date.toLocaleString(LOCALE, localeStringOptions['past date']);
  }
}

function toDateBubble(date) {
  const localeStringOptions = {
    'in the past week': {weekday: 'long'},
    'this year': {month: 'long', day: 'numeric'},
    'past date': {month: 'long', day: 'numeric', year: 'numeric'},
  };
  return `<div class=message-date-separator><p>${getRelativeRepresentation(date, localeStringOptions)}</p></div>`;
}

function toMessageContentString(msg) {
  const sentDate = new Date(msg['sent_time']);
  const dateOutput = function() {
    const localeStringOptions = {
      'in the past week': {weekday: 'long'},
      'this year': {month: 'short', day: 'numeric'},
      'past date': {month: 'numeric', day: 'numeric', year: '2-digit'},
    };
    switch(getRelativeType(sentDate)) {
      case ("TODAY"): return "";
      case ("YESTERDAY"):
      case ("THIS_WEEK"): return `${getRelativeRepresentation(sentDate, localeStringOptions)} at `;
      default: return `<span class='muted'>${getRelativeRepresentation(sentDate, localeStringOptions)}</span> `;
    }
  }();
  const timeOutput = new Date(msg['sent_time']).toLocaleString(LOCALE, LOCALE_STRING_OPTIONS_TIME);
  function wrapMessageInContainer(timestamp, message) {
    return `<div class='${msg['is_sender'] ? 'sent-message' : 'received-message'}'><p${msg['unread'] ? " class='unread"+(msg['unsent'] ? " unsent" : "")+"'" : ""}>${message}&nbsp;<span ${!msg['unread'] && msg['is_sender'] ? "title='Seen'" : ""} class='right message-time-sent'>${timestamp}</span></p></div>`
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
  const message = document.querySelector('.message-entry').value;
  document.querySelector('.message-entry').value = "";
  document.querySelector('.message-entry').setAttribute("placeholder", "Sending…");
  const sentTo = getSelectedId();
  const selectedMessageBody = document.querySelector('.message-chooser-message.selected .last-message-body');
  const rq = new XMLHttpRequest();
  rq.open("POST", "/action/submit-messaging-message", true);
  const params = {
    "to": sentTo,
    "message": message
  };
  rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  rq.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      if (getSelectedId() === sentTo) {
        document.querySelector('.message-entry').setAttribute("placeholder", "Sent!");
      }
      sendMessage.pendingRefreshes.push({
        'id': parseInt(sentTo),
        'rq': refreshMessages(parseInt(sentTo), messagesByFrom, "/action/get-messages?from=")
      });
      sendAlertEmail();
    }
  }
  rq.send(Object.entries(params).map(pair => pair[0] + "=" + pair[1]).join("&"));
  
  sendMessage.pendingRefreshes.filter((refreshRequest) => refreshRequest.id === parseInt(sentTo)).forEach((refreshRequest) => refreshRequest.rq.abort());
  sendMessage.pendingRefreshes = sendMessage.pendingRefreshes.filter((refreshRequest) => refreshRequest.id !== parseInt(sentTo));
  getUpdates.pendingUpdates?.forEach((update) => update.abort());
  
  let node = document.createElement("em");
  node.textContent = message;
  selectedMessageBody.replaceChildren(node);
  
  document.querySelector('.message-chooser-message.selected .last-message-time').textContent = new Date().toLocaleString(LOCALE, LOCALE_STRING_OPTIONS_TIME);
  
  document.querySelectorAll('.message-content .received-message .unread').forEach((unread) => unread.classList.remove("unread"));
  
  if (!isLatestLoadedMessageFromToday) {
    isLatestLoadedMessageFromToday = true;
    document.querySelector('.message-content').innerHTML += toDateBubble(new Date());
  }
  const jsonMessage = {
    'unsent': true,
    'unread': true,
    'is_sender': true,
    'sent_time': new Date(),
    'message': message
  };
  document.querySelector('.message-content').innerHTML += toMessageContentString(jsonMessage);
  messagesByFrom[parseInt(sentTo)].push(jsonMessage);
  
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
      content += toDateBubble(thisDate);
      lastDate = thisDate;
    }
    content += toMessageContentString(msg);
  });
  isLatestLoadedMessageFromToday = lastDate.toLocaleDateString() == new Date().toLocaleDateString();
  document.querySelector('.message-content').classList.remove('old-content');
  document.querySelector('.message-content').innerHTML = content;
  document.querySelector('.message-chooser-message.selected').classList.remove('unread');
  
  const existingInputValue = document.querySelector('.message-entry')?.value;
  let messageFormHTML = `<input disabled type="text" class="message-entry" placeholder="You cannot reply to guests."></input>`;
  if (replyable) {
    let messageEntry = `<input class="message-entry" type="text" placeholder="Type a message…" minlength="1" required></input>`;
    let sendButton = `<button type="submit" class="send-button" title="Send">➤</button>`
    messageFormHTML = messageEntry + sendButton;
  }
  document.getElementById('message-form').innerHTML = messageFormHTML;
  if (existingInputValue && replyable) {
    document.querySelector('.message-entry').value = existingInputValue;
  }
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
      }
    }
    rq.send();
    return rq;
  }
  
  function updatePreviews() {
    function populatePreviews() {
      document.querySelector('.message-chooser').innerHTML = rq.responseText;
    }
    let rq = new XMLHttpRequest();
    rq.open("POST", "/action/show-message-previews", true);
    rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    rq.onreadystatechange = function() {
      if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
        // Retain selected conversation
        let selected = document.querySelector('.message-chooser-message.selected');
        if (selected) {
          let selectedAttribute = selected.getAttribute('conversation') ? 'conversation' : 'last-message';
          let selectedValue = selected.getAttribute('conversation') ?? selected.getAttribute('last-message');
          populatePreviews();
          document.querySelector('.message-chooser-message['+selectedAttribute+'="'+selectedValue+'"]').classList.add('selected');
        } else {
          populatePreviews();
        }
        
        // Update cached conversations that have new messages
        for (const unreadConversation of document.querySelectorAll('.message-chooser-message.unread')) {
          const id = parseInt(unreadConversation.getAttribute('conversation'));
          if (id in messagesByFrom) {
            refreshMessages(id, messagesByFrom, "/action/get-messages?from=");
          }
        }
        
        wireMessageChooser();
      }
    }
    rq.send();
    return rq;
  }
  
  getUpdates.pendingUpdates?.forEach((update) => update.abort());
  getUpdates.pendingUpdates = [updateUnreadCount(), updatePreviews()];
}

function refreshMessages(id, messageCache, uri) {
  // Don't trigger loading animation and don't erase cache until response received
  return getMessages(id, messageCache, uri, true);
}

function getMessages(id, messageCache, uri, quietRefresh=false) {
  function showLoadingAnimation() {
    messageCache[id] = "LOADING";
    document.querySelector('.message-content').classList.remove('old-content');
    document.getElementById('message-form').innerHTML = '';
    document.querySelector('.message-content').innerHTML = `
      <p class="center">Loading messages&hellip;</p>
      <svg class="loading-animation" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: none; display: block; shape-rendering: auto;" width="100px" height="100px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
      <circle cx="50" cy="50" fill="none" stroke="#a9b" stroke-width="8" r="40" stroke-dasharray="160">
        <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="0.8s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
      </circle></svg>
    `;
  }
  
  const silent = quietRefresh;
  const force = quietRefresh;
  
  const name = document.querySelector('.message-chooser-message.selected .conversation-partner').textContent;
  document.querySelector('.message-viewer > .conversation-partner').textContent = name;
  // Response received already or request initiated already
  if (!force && id in messageCache) {
    if (!silent && (messageCache[id] === "PENDING" || messageCache[id] === "LOADING")) {
      showLoadingAnimation();
      return;
    }
    setContent(messageCache == messagesByFrom, ...messageCache[id]);
    return;
  }
  if (!silent) {
    messageCache[id] = "PENDING";
    // Wait two seconds for a response before being able to retry
    setTimeout(function() {
      if (messageCache[id] === "PENDING") {
        delete messageCache[id];
      }
    }, 2000);
  }
  let rq = new XMLHttpRequest();
  rq.open("GET", uri + id, true);
  rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  rq.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      clearTimeout(delayedLoad);
      messageCache[id] = JSON.parse(rq.responseText);
      if (parseInt(getSelectedId()) === id) {
        getMessages(id, messageCache, uri);
      }
    }
  }
  const delayedLoad = silent ? undefined : setTimeout(function() {
    // Prevent animation when conversation no longer selected or animation already started
    if (parseInt(getSelectedId()) !== id || messageCache[id] === "LOADING") {
      return;
    }
    showLoadingAnimation();
  }, 500);
  rq.send();
  return rq;
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

function pollForMessagesWhileFocused(interval) {
  const updateOrStopPolling = function() {
    const resumePolling = function() {
      poll = addPoll();
      updateOrStopPolling();
      window.removeEventListener("focus", resumePolling);
    }
    if (document.hasFocus()) {
      getUpdates();
    } else {
      clearInterval(poll);
      window.addEventListener("focus", resumePolling);
    }
  }
  const addPoll = function() {
    return setInterval(updateOrStopPolling, interval);
  }
  let poll = addPoll();
}

wireMessageChooser();
pollForMessagesWhileFocused(2000);
