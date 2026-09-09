const testTarget = document.getElementById("url");
function getTarget() {
  return document.getElementById("url-link");
}

function onUpdate() {
  const target = getTarget();
  if (!testTarget.value) {
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
  testTarget.addEventListener("input", function() {
    const target = getTarget();
    target.style.display = "none";
  });
  testTarget.addEventListener("blur", function() {
    const target = getTarget();
    target.style.display = "";
  });
  testTarget.addEventListener("change", onUpdate);
}
onUpdate.call(testTarget);
handleUrlLinkInput();
