function inputHandler(e) {
    let query = e.target.value;
    Array.from(document.getElementsByClassName('restaurant-widget')).forEach(function(restaurant) {
        let name = restaurant.getElementsByClassName('restaurant-name')[0].getInnerHTML();
        if (name.toLowerCase().includes(query.toLowerCase())) {
            if (restaurant.lastDisplay != undefined) {
                restaurant.style.display = restaurant.lastDisplay;
            }
        } else if (restaurant.style.display != "none") {
            restaurant.lastDisplay = restaurant.style.display;
            restaurant.style.display = "none";
        }
    });
}
const source = document.getElementById('search');
if (source !== null)
  source.addEventListener('input', inputHandler);