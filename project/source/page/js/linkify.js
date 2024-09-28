// From https://stackoverflow.com/a/8943487
export function linkify(text) {
  var urlRegex = /(\b(https):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
  return text.replace(urlRegex, function(url) {
    return '<a target="_blank" class="link" href="' + url + '">' + url + '</a>';
  });
}