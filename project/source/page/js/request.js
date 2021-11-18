function request() {
  event.preventDefault();
  var rq = new XMLHttpRequest();
  rq.open("POST", "../../action/submit-gift", true);
  rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  var params = "name=" + document.getElementById("name").value + "&url=" + document.getElementById("url").value + "&comments=" + document.getElementById("comments").value;
  rq.send(params);
  document.getElementById("request-form").reset();
  document.getElementById("message").hidden = false;
}