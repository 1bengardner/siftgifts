function getTarget() {
  return document.getElementById("url-link");
}

function onUpdate() {
  const target = getTarget();
  if (!this.value) {
    target.replaceWith(Object.assign(document.createElement("span"), {
      id: "url-link",
    }));
  } else if (this.checkValidity()) {
    target.replaceWith(Object.assign(document.createElement("a"), {
      id: "url-link",
      title: "Open in a new tab",
      href: this.value,
      target: "_blank",
      textContent: "🔗",
    }));
  } else {
    target.replaceWith(Object.assign(document.createElement("span"), {
      id: "url-link",
      title: "Don't forget the https://",
      textContent: "💭",
    }));
    getTarget().style.cursor = "help";
  }
}

function handleUrlLinkInput() {
  this.addEventListener("input", function() {
    const target = getTarget();
    target.style.display = "none";
  });
  this.addEventListener("blur", function() {
    const target = getTarget();
    target.style.display = "";
  });
  this.addEventListener("change", onUpdate);
  document.getElementById("request-form").addEventListener("reset", onUpdate.bind({ value: null, }));
}
const testTarget = document.getElementById("url");
onUpdate.call(testTarget);
handleUrlLinkInput.call(testTarget);
