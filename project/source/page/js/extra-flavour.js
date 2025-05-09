function clickHandler(source) {
  let inputs = source.form.querySelectorAll('input, textarea');
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
    if (source.form.requestSubmit !== undefined) {
      source.form.requestSubmit();
    } else {
      if (source.form.onsubmit !== null) {
        source.form.onsubmit();
      }
      source.form.submit();
    }
    source.setAttribute("disabled", "");
    // usually the submit event occurs after the click event is done, but submit is now disabled, so submit must be called manually before disabling
  }
}
const sources = document.querySelectorAll('.submit-button');
for (const source of sources) {
  source.addEventListener('click', () => clickHandler(source));
}