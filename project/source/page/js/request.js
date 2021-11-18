function request() {
  event.preventDefault();
  var rq = new XMLHttpRequest();
  rq.open("POST", "../../action/submit-gift", true);
  rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  const keys = [
    "name",
    "url",
    "comments"
  ];
  var params = keys.map(x => x + "=" + document.getElementById(x).value).join('&');
  console.log(params);
  rq.send(params);
  document.getElementById("request-form").reset();
  document.getElementById("message").hidden = false;
}