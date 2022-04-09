var messages = {};
var localeStrings = {
  'time': {hour: 'numeric', minute: '2-digit'},
  'day': {month: 'short', day: 'numeric', hour: 'numeric', minute: '2-digit'},
  'year': {month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit'}
};

function setContent(...messageData) {
  let content = "";
  let currentDate = new Date();
  messageData.forEach(function(messageDatum) {
    let sentDate = new Date(messageDatum['sent_time']);
    let localeString = localeStrings['time'];
    if (sentDate.getYear() < currentDate.getYear()) {
      localeString = localeStrings['year'];
    }
    else if (sentDate.getDate() < currentDate.getDate() || sentDate.getMonth() < currentDate.getMonth()) {
      localeString = localeStrings['day'];
    }
    content += `<p class='${messageDatum['is_sender'] ? 'sent-message' : 'received-message'}'><span class='right message-time-sent'>${new Date(messageDatum['sent_time']).toLocaleString(undefined, localeString)}</span>${messageDatum['message']}</p>`;
  });
  document.querySelectorAll('.message-content')[0].innerHTML = content;
  let messageEntry = `<input class="message-entry" placeholder="Type a message…"></input>`;
  document.getElementById('message-form').innerHTML = messageEntry;
  document.getElementById('message-form').onsubmit = function(e) {
    sendMessage();
    e.preventDefault();
  };
}

function sendMessage() {
  let message = document.querySelectorAll('.message-entry')[0].value;
  let conversationPartner = document.querySelectorAll('.message-chooser-message.selected')[0].getAttribute('conversation');
  let selectedMessage = document.querySelectorAll('.message-chooser-message.selected .preview')[0];
  let rq = new XMLHttpRequest();
  rq.open("POST", "/action/send-message", true);
  const params = {
    "to": conversationPartner,
    "from": document.getElementById('message-form').getAttribute('user'),
    "message": message
  };
  rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  rq.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      delete messages[parseInt(conversationPartner)];
      setMessages(parseInt(conversationPartner));
      
      let node = document.createElement("em");
      node.textContent = message;
      selectedMessage.replaceChildren(node);
      document.querySelectorAll('.message-chooser-message.selected .last-message-time')[0].textContent = new Date().toLocaleString(undefined, localeStrings['time']);
      // TODO: Move updated message chooser message to the top of the list
    }
  }
  rq.send(Object.entries(params).map(pair => pair[0] + "=" + pair[1]).join("&"));
}

function setMessages(id) {
  if (id in messages) {
    setContent(...messages[id]);
    return;
  }
  let rq = new XMLHttpRequest();
  rq.open("GET", "/action/get-messages?from=" + id, true);
  rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  rq.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      clearTimeout(loading);
      messages[id] = JSON.parse(rq.responseText);
      setMessages(id);
    }
  }
  let loading = setTimeout(function() {
    document.querySelectorAll('.message-content')[0].innerHTML = `
<?xml version="1.0" encoding="utf-8"?>
<svg class="loading-animation" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: none; display: block; shape-rendering: auto;" width="256px" height="256px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
<g transform="rotate(0 50 50)">
  <rect x="47" y="28" rx="3" ry="6" width="6" height="12" fill="#539">
    <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.9166666666666666s" repeatCount="indefinite"></animate>
  </rect>
</g><g transform="rotate(30 50 50)">
  <rect x="47" y="28" rx="3" ry="6" width="6" height="12" fill="#539">
    <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.8333333333333334s" repeatCount="indefinite"></animate>
  </rect>
</g><g transform="rotate(60 50 50)">
  <rect x="47" y="28" rx="3" ry="6" width="6" height="12" fill="#539">
    <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.75s" repeatCount="indefinite"></animate>
  </rect>
</g><g transform="rotate(90 50 50)">
  <rect x="47" y="28" rx="3" ry="6" width="6" height="12" fill="#539">
    <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.6666666666666666s" repeatCount="indefinite"></animate>
  </rect>
</g><g transform="rotate(120 50 50)">
  <rect x="47" y="28" rx="3" ry="6" width="6" height="12" fill="#539">
    <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.5833333333333334s" repeatCount="indefinite"></animate>
  </rect>
</g><g transform="rotate(150 50 50)">
  <rect x="47" y="28" rx="3" ry="6" width="6" height="12" fill="#539">
    <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.5s" repeatCount="indefinite"></animate>
  </rect>
</g><g transform="rotate(180 50 50)">
  <rect x="47" y="28" rx="3" ry="6" width="6" height="12" fill="#539">
    <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.4166666666666667s" repeatCount="indefinite"></animate>
  </rect>
</g><g transform="rotate(210 50 50)">
  <rect x="47" y="28" rx="3" ry="6" width="6" height="12" fill="#539">
    <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.3333333333333333s" repeatCount="indefinite"></animate>
  </rect>
</g><g transform="rotate(240 50 50)">
  <rect x="47" y="28" rx="3" ry="6" width="6" height="12" fill="#539">
    <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.25s" repeatCount="indefinite"></animate>
  </rect>
</g><g transform="rotate(270 50 50)">
  <rect x="47" y="28" rx="3" ry="6" width="6" height="12" fill="#539">
    <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.16666666666666666s" repeatCount="indefinite"></animate>
  </rect>
</g><g transform="rotate(300 50 50)">
  <rect x="47" y="28" rx="3" ry="6" width="6" height="12" fill="#539">
    <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.08333333333333333s" repeatCount="indefinite"></animate>
  </rect>
</g><g transform="rotate(330 50 50)">
  <rect x="47" y="28" rx="3" ry="6" width="6" height="12" fill="#539">
    <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="0s" repeatCount="indefinite"></animate>
  </rect>
</g>
    `;
  }, 500);
  rq.send();
}

document.querySelectorAll('.message-chooser-message').forEach(message => {
  message.onclick = function() {
    document.querySelectorAll('.message-chooser-message').forEach(message => {
      message.classList.remove('selected');
    });
    message.classList.add('selected');
    setMessages(parseInt(message.getAttribute('conversation')));
  }
});