function remove(id, name) {
  if (confirm("Do you want to REMOVE " + name + " from your wishlist?")) {
    var rq = new XMLHttpRequest();
    rq.open("POST", "../../action/remove-gift", true);
    rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    rq.onreadystatechange = function() {
      if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
        location.reload();
      }
    }
    var params = "id=" + id;
    rq.send(params);
  }
}