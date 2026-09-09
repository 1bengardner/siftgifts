function request() {
  event.preventDefault();
  var rq = new XMLHttpRequest();
  rq.open("POST", "../../action/submit-gift-to-private", true);
  rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  rq.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      document.getElementById("request-form").reset();
      document.querySelector(".submit-button").disabled = false;
      
      document.querySelector(".notification-box").replaceWith(document.createRange().createContextualFragment(this.responseText));
    }
  }
  const valueKeys = [
    "name",
    "url",
    "price",
    "comments",
    "wishlist",
  ];
  var params = valueKeys.map(x => x + "=" + encodeURIComponent(document.getElementById(x).value)).join('&');
  params += "&unreservable=" + (document.getElementById("unreservable").checked ? "1" : "0");
  rq.send(params);
}