function reserve(id, name) {
  if (confirm("Are you sure you want to reserve " + name + "?")) {
    var rq = new XMLHttpRequest();
    rq.open("POST", "../../action/reserve-gift", true);
    rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    rq.onreadystatechange = function() {
      if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
        document.getElementById(id).labels[0].innerHTML = "Reserved!";
      }
    }
    var params = "id=" + id;
    rq.send(params);
    document.getElementById(id).disabled = true;
  } else {
    document.getElementById(id).checked = false;
  }
}

function toggle(btn) {
  var rq = new XMLHttpRequest();
  rq.open("POST", "../../action/reserve-gift-toggle", true);
  rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  rq.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      document.getElementById(btn.getAttribute("id")).labels[0].innerHTML = rq.responseText == 1 ? "Reserved" : "Reserve";
    }
  }
  var params = "id=" + btn.getAttribute("gift");
  rq.send(params);
}

function enableToggles() {
  Array.from(document.getElementsByClassName('admin-reserve')).forEach(function(reserve) {
    if (reserve.lastDisplay != undefined) {
      var tmp = reserve.style.display;
      reserve.style.display = reserve.lastDisplay;
      reserve.lastDisplay = tmp;
    } else {
      reserve.lastDisplay = reserve.style.display;
      reserve.style.display = reserve.getAttribute("display-when-toggled");
    }
  });
}