import { linkify } from "./linkify.js";

function linkifyNotes() {
  for (const node of document.querySelectorAll('.gift-notes')) {
    node.innerHTML = linkify(node.innerHTML);
  }
}

linkifyNotes();
