function reserve(id, name) {
  document.getElementById(id).disabled = true;
  const rq = new XMLHttpRequest();
  rq.open("POST", "../../action/trial-reserve", true);
  rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  rq.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE) {
      if (this.status === 200) {
        confirmReserve(id, name);
      } else if (this.responseText) {
        document.getElementById(id).closest(".gift-widget").querySelector(".notification-box").replaceWith(document.createRange().createContextualFragment(this.responseText));
        return;
      } else {
        alert("There was an error reserving this gift. Try again.");
        document.getElementById(id).disabled = false;
      }
    }
  }
  const params = "id=" + id;
  rq.send(params);
}

function confirmReserve(id, name) {
  if (confirm("Are you sure you want to reserve " + name + "?")) {
    var rq = new XMLHttpRequest();
    rq.open("POST", "../../action/reserve-gift", true);
    rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    rq.onreadystatechange = function() {
      if (this.readyState === XMLHttpRequest.DONE) {
        if (this.status === 200) {
          document.getElementById(id).value = "Reserved!";
        } else if (!this.responseText) {
          alert("There was an error reserving this gift. Try again.");
          document.getElementById(id).disabled = false;
          return;
        }
        document.getElementById(id).closest(".gift-widget").querySelector(".notification-box").replaceWith(document.createRange().createContextualFragment(this.responseText));
      }
    }
    var params = "id=" + id;
    rq.send(params);
  } else {
    document.getElementById(id).disabled = false;
  }
}

function toggle(btn, name) {
  if (!confirm(btn.checked ? `Reserve ${name}?` : `Mark ${name} as available?`)) {
    btn.checked = !btn.checked;
    return;
  }
  var rq = new XMLHttpRequest();
  rq.open("POST", "../../action/reserve-gift-toggle", true);
  rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  rq.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      const doesServerSeeReserved = rq.responseText == 1;
      document.getElementById(btn.getAttribute("id")).labels[0].innerHTML = doesServerSeeReserved ? "Reserved" : "Reserve";
      btn.checked = doesServerSeeReserved;
    }
  }
  var params = "id=" + btn.getAttribute("gift");
  rq.send(params);
}

function enableToggles(e) {
  if (!enableToggles.hasHeededWarning && !confirm("You will be able to see if anyone got you your gifts!")) {
    e.target.checked = false;
    return;
  }
  enableToggles.hasHeededWarning = true;
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