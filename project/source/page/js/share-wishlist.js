if (navigator.canShare) {
  document.querySelectorAll('.clipboard-button').forEach(function(elem) {
    elem.title = "Share";
    elem.onclick = () => navigator.share({
      title: 'Sift.gifts wishlist link',
      url: elem.getAttribute('url'),
    });
    elem.innerHTML = "<strong>Share!</strong>";
  });
} else {
  document.querySelectorAll('.clipboard-button').forEach(function(elem) {
    let removeTextEvent = null;
    elem.onclick = () => {
      clearTimeout(removeTextEvent);
      navigator.clipboard.writeText(elem.getAttribute('url'));
      const reaction = elem.parentNode.querySelector('.clipboard-copy-reaction');
      reaction.textContent = "Copied!";
      reaction.style.animation = "0.3s ease-in-out drop-in";
      removeTextEvent = setTimeout(() => {
        reaction.textContent = null;
        reaction.style.animation = "";
      }, 2000);
    };
  });
}