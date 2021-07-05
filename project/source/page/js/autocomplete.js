function inputHandler(e) {
    let query = e.target.value;
    Array.from(document.getElementsByClassName('restaurant-widget')).forEach(function(restaurant) {
        let name = restaurant.getElementsByClassName('restaurant-name')[0].getInnerHTML();
        if (name.toLowerCase().includes(query.toLowerCase())) {
            restaurant.hidden = false;
        } else {
            restaurant.hidden = true;
        }
    });
}
const source = document.getElementById('search');
source.addEventListener('input', inputHandler);