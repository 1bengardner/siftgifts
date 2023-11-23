function edit() {
  event.preventDefault();
  var rq = new XMLHttpRequest();
  rq.open("POST", "../../action/submit-edit-gift", true);
  rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  rq.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      document.getElementById("name-heading").textContent = newName;
      document.querySelector(".submit-button").disabled = false;
      
      document.querySelector(".notification-box").replaceWith(document.createRange().createContextualFragment(this.responseText));
    }
  }
  const keys = [
    "id",
    "name",
    "url",
    "comments"
  ];
  var params = keys.map(x => x + "=" + document.getElementById(x).value).join('&');
  const newName = document.getElementById("name").value;
  rq.send(params);
}
