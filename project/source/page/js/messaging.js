var messagesById = {};
var messagesByFrom = {};
var localeStrings = {
  'time': {hour: 'numeric', minute: '2-digit'},
  'date': {month: 'numeric', day: 'numeric', year: '2-digit'},
};

// From https://stackoverflow.com/a/8943487
function linkify(text) {
  var urlRegex = /(\b(https):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
  return text.replace(urlRegex, function(url) {
    return '<a target="_blank" class="link" href="' + url + '">' + url + '</a>';
  });
}
  
function toMessageContentString(msg) {
  let currentDate = new Date();
  let sentDate = new Date(msg['sent_time']);
  let sentToday = !(sentDate.getDate() < currentDate.getDate() || sentDate.getMonth() < currentDate.getMonth() || sentDate.getYear() < currentDate.getYear())
  return `<div class='${msg['is_sender'] ? 'sent-message' : 'received-message'}'><p${msg['unread'] ? " class='unread"+(msg['unsent'] ? " unsent" : "")+"'" : ""}><span ${!msg['unread'] && msg['is_sender'] ? "title='Seen'" : ""} class='right message-time-sent'>${sentToday ? "Today at " : "<span class='muted'>"+new Date(msg['sent_time']).toLocaleString(undefined, localeStrings['date'])+"</span> "}${new Date(msg['sent_time']).toLocaleString(undefined, localeStrings['time'])}</span>${linkify(msg['message'])}</p></div>`;
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
  messageData.forEach(function(msg) {
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
  let rq = new XMLHttpRequest();
  rq.open("GET", uri + id, true);
  rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  rq.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      clearTimeout(loading);
      messageCache[id] = JSON.parse(rq.responseText);
      getMessages(id, messageCache, uri);
    }
  }
  let loading = setTimeout(function() {
    document.querySelector('.message-content').classList.remove('old-content');
    document.getElementById('message-form').innerHTML = '';
    document.querySelector('.message-content').innerHTML = `
<svg class="loading-animation" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: none; display: block; shape-rendering: auto;" width="256px" height="256px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
<g transform="rotate(0 50 50)">
  <rect x="47" y="28" rx="3" ry="6" width="6" height="12" fill="#985dbf">
    <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.9166666666666666s" repeatCount="indefinite"></animate>
  </rect>
</g><g transform="rotate(30 50 50)">
  <rect x="47" y="28" rx="3" ry="6" width="6" height="12" fill="#985dbf">
    <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.8333333333333334s" repeatCount="indefinite"></animate>
  </rect>
</g><g transform="rotate(60 50 50)">
  <rect x="47" y="28" rx="3" ry="6" width="6" height="12" fill="#985dbf">
    <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.75s" repeatCount="indefinite"></animate>
  </rect>
</g><g transform="rotate(90 50 50)">
  <rect x="47" y="28" rx="3" ry="6" width="6" height="12" fill="#985dbf">
    <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.6666666666666666s" repeatCount="indefinite"></animate>
  </rect>
</g><g transform="rotate(120 50 50)">
  <rect x="47" y="28" rx="3" ry="6" width="6" height="12" fill="#985dbf">
    <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.5833333333333334s" repeatCount="indefinite"></animate>
  </rect>
</g><g transform="rotate(150 50 50)">
  <rect x="47" y="28" rx="3" ry="6" width="6" height="12" fill="#985dbf">
    <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.5s" repeatCount="indefinite"></animate>
  </rect>
</g><g transform="rotate(180 50 50)">
  <rect x="47" y="28" rx="3" ry="6" width="6" height="12" fill="#985dbf">
    <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.4166666666666667s" repeatCount="indefinite"></animate>
  </rect>
</g><g transform="rotate(210 50 50)">
  <rect x="47" y="28" rx="3" ry="6" width="6" height="12" fill="#985dbf">
    <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.3333333333333333s" repeatCount="indefinite"></animate>
  </rect>
</g><g transform="rotate(240 50 50)">
  <rect x="47" y="28" rx="3" ry="6" width="6" height="12" fill="#985dbf">
    <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.25s" repeatCount="indefinite"></animate>
  </rect>
</g><g transform="rotate(270 50 50)">
  <rect x="47" y="28" rx="3" ry="6" width="6" height="12" fill="#985dbf">
    <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.16666666666666666s" repeatCount="indefinite"></animate>
  </rect>
</g><g transform="rotate(300 50 50)">
  <rect x="47" y="28" rx="3" ry="6" width="6" height="12" fill="#985dbf">
    <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.08333333333333333s" repeatCount="indefinite"></animate>
  </rect>
</g><g transform="rotate(330 50 50)">
  <rect x="47" y="28" rx="3" ry="6" width="6" height="12" fill="#985dbf">
    <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="0s" repeatCount="indefinite"></animate>
  </rect>
</g>
    `;
  }, 500);
  rq.send();
}

function navigateToChooser(e) {
    document.querySelector('.message-viewer').classList.remove('visible-on-mobile');
    document.querySelector('.message-chooser').classList.add('visible-on-mobile');
    e.preventDefault();
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