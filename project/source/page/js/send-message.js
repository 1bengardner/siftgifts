function send() {
  event.preventDefault();
  let rq = new XMLHttpRequest();
  rq.open("POST", "/action/submit-guest-message", true);
  rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  rq.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      if (!rq.responseText) {
        window.location.href = "/messaging";
        return;
      }
      document.getElementById("message").value = null;
      document.querySelector(".submit-button").disabled = false;
      
      document.querySelector(".notification-box").replaceWith(document.createRange().createContextualFragment(this.responseText));
    }
  }
  const keys = [
    "to",
    "from",
    "message"
  ];
  const params = keys.map(x => x + "=" + document.getElementById(x).value).join('&');
  rq.send(params);
}