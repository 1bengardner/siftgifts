const memory = function() {
  const StorageKeys = Object.freeze({
    RESERVED: "reserved gifts",
  });

  function put(id) {
    try {
      const res = get();
      res.push(id);
      localStorage.setItem(StorageKeys.RESERVED, JSON.stringify(res));
    } catch (error) {
      console.error(error);
      console.warn("Did not save reservation to localStorage.");
    }
  }

  function get() {
    try {
      return JSON.parse(localStorage.getItem(StorageKeys.RESERVED)) ?? [];
    } catch (error) {
      console.error(error);
      console.warn("Could not get reservation from localStorage.");
    }
  }

  function erase(id) {
    try {
      const res = get();
      const index = res.indexOf(id);
      if (index !== -1) {
        res.splice(index, 1);
        localStorage.setItem(StorageKeys.RESERVED, JSON.stringify(res));
      }
    } catch (error) {
      console.error(error);
      console.warn("Could not remove reservation from localStorage.");
    }
  }

  return {
    put,
    get,
    erase,
  }
}();

function unreserve(id) {
  if (confirm("You reserved this gift. Do you want to unreserve it?")) {
    var rq = new XMLHttpRequest();
    rq.open("POST", "../../action/unreserve-gift", true);
    rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    rq.onreadystatechange = function() {
      if (this.readyState === XMLHttpRequest.DONE) {
        if (this.status === 200) {
          document.getElementById(id).value = "Reserve";
          memory.erase(id);
          document.getElementById(id).onclick = () => reserve(id);
        } else if (!this.responseText) {
          alert("There was an error unreserving this gift. Try again.");
          return;
        }
        document.getElementById(id).closest(".gift-widget").querySelector(".notification-box").replaceWith(document.createRange().createContextualFragment(this.responseText));
      }
    }
    var params = "id=" + id;
    rq.send(params);
  }
}

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
  if (confirm("Are you sure you want to reserve " + (name ?? "this gift") + "?")) {
    var rq = new XMLHttpRequest();
    rq.open("POST", "../../action/reserve-gift", true);
    rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    rq.onreadystatechange = function() {
      if (this.readyState === XMLHttpRequest.DONE) {
        if (this.status === 200) {
          document.getElementById(id).value = "Reserved!";
          memory.put(id);
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

function adminReserve(btn, name) {
  if (!confirm(btn.checked ? `Reserve ${name}?` : `Mark ${name} as available?`)) {
    btn.checked = !btn.checked;
    return;
  }
  var rq = new XMLHttpRequest();
  rq.open("POST", "../../action/reserve-gift-admin", true);
  rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  rq.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE) {
      if (this.status !== 200 && this.responseText) {
        btn.closest(".gift-widget").querySelector(".notification-box").replaceWith(document.createRange().createContextualFragment(this.responseText));
        btn.checked = !btn.checked;
        return;
      }
      document.getElementById(btn.getAttribute("id")).labels[0].innerHTML = btn.checked ? "Reserved" : "Reserve";
    }
  }
  var params = "id=" + btn.getAttribute("gift") + "&reserve=" + Number(btn.checked);
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