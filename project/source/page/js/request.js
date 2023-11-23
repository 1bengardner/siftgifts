function request() {
  event.preventDefault();
  var rq = new XMLHttpRequest();
  rq.open("POST", "../../action/submit-gift", true);
  rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  rq.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      document.getElementById("request-form").reset();
      document.querySelector(".submit-button").disabled = false;
      
      document.querySelector(".notification-box").replaceWith(document.createRange().createContextualFragment(this.responseText));
    }
  }
  const keys = [
    "name",
    "url",
    "comments"
  ];
  var params = keys.map(x => x + "=" + encodeURIComponent(document.getElementById(x).value)).join('&');
  rq.send(params);
}