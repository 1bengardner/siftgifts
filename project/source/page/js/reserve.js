function reserve(id, name) {
  if (confirm("Are you sure you want to reserve " + name + "?")) {
    var rq = new XMLHttpRequest();
    rq.open("POST", "../../action/reserve-gift", true);
    rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    var params = "id=" + id;
    rq.send(params);
    document.getElementById(id).disabled = true;
  } else {
    document.getElementById(id).checked = false;
  }
}