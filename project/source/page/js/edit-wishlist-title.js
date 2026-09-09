function addTitleChangeHandler(target) {
  const id = new URLSearchParams(new URL(document.currentScript.src).search).get("id");
  let dontUpdate = false;
  let rq = new XMLHttpRequest();
  rq.onreadystatechange = function() {
    if (!dontUpdate && this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      target.textContent = this.responseText;
    }
  }
  function updateTitle(title) {
    rq.abort();
    rq.open("POST", "../../action/submit-wishlist-name-change", true);
    rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    rq.send(`id=${id}&name=${encodeURIComponent(title)}`);
  }
  target.contentEditable = true;
  let beforeEdit = "";
  target.addEventListener("focus", function() {
    dontUpdate = true;
    beforeEdit = this.textContent;
  });
  target.addEventListener("blur", function() {
    if (beforeEdit === this.textContent) return;
    updateTitle(this.textContent);
    dontUpdate = false;
  });
}

addTitleChangeHandler(document.getElementById("wishlist-title"));
