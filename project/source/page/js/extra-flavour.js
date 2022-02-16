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
    // poor browser support for requestSubmit
    if (document.querySelector('form').requestSubmit !== undefined) {
      document.querySelector('form').requestSubmit();
    } else {
      if (document.querySelector('form').onsubmit !== null) {
        document.querySelector('form').onsubmit();
      }
      document.querySelector('form').submit();
    }
    source.setAttribute("disabled", "");
    // usually the submit event occurs after the click event is done, but submit is now disabled, so submit must be called manually before disabling
  }
}
const source = document.querySelector('.submit-button');
if (source.length !== null)
  source.addEventListener('click', clickHandler);