function clickHandler(e) {
  let inputs = document.getElementsByTagName('input');
  let validSubmission = true;
  for (const input of inputs) {
    if (!input.checkValidity()) {
      input.classList.add('invalid-input');
      validSubmission = false;
    } else {
      input.classList.remove('invalid-input');
    }
  }
  if (validSubmission) {
    source.setAttribute("disabled", "");
    document.querySelector('form').submit();
  }
}
const source = document.querySelector('.submit-button');
if (source.length !== null)
  source.addEventListener('click', clickHandler);