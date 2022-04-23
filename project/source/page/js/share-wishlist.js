let wishlistUrl = document.querySelectorAll('.clipboard-button')[0].getAttribute('url');

if (navigator.canShare) {
  document.querySelectorAll('.clipboard-button').forEach(function(elem) {
    elem.title = "Share";
    elem.onclick = () => navigator.share({
      title: 'Sift.gifts wishlist link',
      url: wishlistUrl
    });
    elem.innerHTML = "<strong>Share!</strong>";
  });
}