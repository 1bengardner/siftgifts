function send() {
  event.preventDefault();
  let rq = new XMLHttpRequest();
  rq.open("POST", "/action/submit-guest-message", true);
  rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  rq.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      if (rq.responseText) {
        window.location.href = "/messaging";
        return;
      }
      // TODO: Use notifications instead of this
      document.getElementById("message").value = null;
      document.getElementById("notifications").hidden = false;
      document.querySelector(".submit-button").disabled = false;
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