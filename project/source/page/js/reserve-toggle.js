function remove(id, name) {
  if (confirm("Do you want to REMOVE " + name + " from your wishlist?")) {
    var rq = new XMLHttpRequest();
    rq.open("POST", "../../action/remove-gift", true);
    rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    var params = "id=" + id;
    rq.send(params);
    location.reload();
  }
}