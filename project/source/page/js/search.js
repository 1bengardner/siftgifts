function inputHandler(e) {
  let query = e.target.value;
  Array.from(document.getElementsByClassName('gift-widget')).forEach(function(gift) {
    let name = gift.getElementsByClassName('gift-name')[0].getInnerHTML();
    if (name.toLowerCase().includes(query.toLowerCase())) {
        if (gift.lastDisplay != undefined) {
            gift.style.display = gift.lastDisplay;
        }
    } else if (gift.style.display != "none") {
        gift.lastDisplay = gift.style.display;
        gift.style.display = "none";
    }
  });
}
const source = document.getElementById('search');
if (source !== null)
  source.addEventListener('input', inputHandler);