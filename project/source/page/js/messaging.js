var messagesById = {};
var messagesByFrom = {};
var localeStrings = {
  'time': {hour: 'numeric', minute: '2-digit'},
  'date': {month: 'numeric', day: 'numeric', year: '2-digit'},
};

function setContent(replyable, ...messageData) {
  // From https://stackoverflow.com/a/8943487
  function linkify(text) {
    var urlRegex = /(\b(https):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
    return text.replace(urlRegex, function(url) {
      return '<a target="_blank" class="link" href="' + url + '">' + url + '</a>';
    });
  }
  
  let content = "";
  let currentDate = new Date();
  messageData.forEach(function(msg) {
    let sentDate = new Date(msg['sent_time']);
    let sentToday = !(sentDate.getDate() < currentDate.getDate() || sentDate.getMonth() < currentDate.getMonth() || sentDate.getYear() < currentDate.getYear())
  content += `<div class='${msg['is_sender'] ? 'sent-message' : 'received-message'}'><p${msg['unread'] ? " class='unread'" : ""}><span ${!msg['unread'] && msg['is_sender'] ? "title='Seen'" : ""} class='right message-time-sent'>${sentToday ? "" : "<span class='muted'>"+new Date(msg['sent_time']).toLocaleString(undefined, localeStrings['date'])+"</span> "}${new Date(msg['sent_time']).toLocaleString(undefined, localeStrings['time'])}</span>${linkify(msg['message'])}</p></div>`;
  });
  document.querySelectorAll('.message-content')[0].classList.remove('old-content');
  document.querySelectorAll('.message-content')[0].innerHTML = content;
  document.querySelectorAll('.message-chooser-message.selected')[0].classList.remove('unread');
  
  let messageEntry = `<input disabled class="message-entry" placeholder="You cannot reply to guests."></input>`;
  if (replyable) {
    messageEntry = `<input class="message-entry" placeholder="Type a message…" minlength="1" required></input>`;
  }
  document.getElementById('message-form').innerHTML = messageEntry;
  document.getElementById('message-form').onsubmit = function(e) {
    sendMessage();
    e.preventDefault();
  };
  let viewer = document.querySelectorAll('.message-viewer')[0];
  viewer.scrollTop = viewer.scrollHeight;
}

function sendMessage() {
  let message = document.querySelectorAll('.message-entry')[0].value;
  let conversationPartner = document.querySelectorAll('.message-chooser-message.selected')[0].getAttribute('conversation');
  let selectedMessageBody = document.querySelectorAll('.message-chooser-message.selected .last-message-body')[0];
  let rq = new XMLHttpRequest();
  rq.open("POST", "/action/submit-message", true);
  const params = {
    "to": conversationPartner,
    "message": message
  };
  rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  rq.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      delete messagesByFrom[parseInt(conversationPartner)];
      getMessages(parseInt(conversationPartner), messagesByFrom, "/action/get-messages?from=");
      
      let node = document.createElement("em");
      node.textContent = message;
      selectedMessageBody.replaceChildren(node);
      document.querySelectorAll('.message-chooser-message.selected .last-message-time')[0].textContent = new Date().toLocaleString(undefined, localeStrings['time']);
      // TODO: Move updated message chooser message to the top of the list
    }
  }
  rq.send(Object.entries(params).map(pair => pair[0] + "=" + pair[1]).join("&"));
}

function getMessages(id, messageCache, uri) {
  let name = document.querySelectorAll('.message-chooser-message.selected .conversation-partner')[0].textContent;
  document.querySelectorAll('.message-viewer > .conversation-partner')[0].textContent = name;
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
    document.querySelectorAll('.message-content')[0].classList.remove('old-content');
    document.getElementById('message-form').innerHTML = '';
    document.querySelectorAll('.message-content')[0].innerHTML = `
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
    document.querySelectorAll('.message-viewer')[0].classList.remove('visible-on-mobile');
    document.querySelectorAll('.message-chooser')[0].classList.add('visible-on-mobile');
    e.preventDefault();
}

document.querySelectorAll('.message-chooser-message').forEach(message => {
  message.onclick = function() {
    document.querySelectorAll('.message-chooser')[0].classList.remove('visible-on-mobile');
    document.querySelectorAll('.message-viewer')[0].classList.add('visible-on-mobile');
    
    document.querySelectorAll('.message-content')[0].classList.add('old-content');
    
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