/* *********************** */
/* Declaration of constant */
/* *********************** */

// Form Targeting
const loginForm = document.getElementById('loginForm')

// Targeting fillable fields in loginForm
const areaLoginForm = {
  "email" : loginForm.querySelector('#user-email'),
  "password" : loginForm.querySelector('#user-password')
}

// Targeting the button to send form data from loginForm
const buttonSubmit = loginForm.querySelector('#user-submit')

/* ************************* */
/* Declarations of functions */
/* ************************* */

// Validates fields on a form
function validateField(field, regex) {
  const valueField = field.value.trim()

  if (!regex.test(valueField)) {
    field.classList.add('is-invalid')
    return false
  } else {
    field.classList.remove('is-invalid')
    return true
  }
}


// Checking the validity of the form fields after clicking the button
buttonSubmit.addEventListener('click', function() {
  const isFieldValid = {
    "email" : validateField(areaLoginForm.email,
      /^(?=.{6,100}$)[a-z0-9._%+-]{1,64}@[a-z0-9.-]{1,63}\.[a-z]{2,}$/),
    "password" : validateField(areaLoginForm.password,
      /^(?=.*[a-zàâäéèêëïîôöùûüÿç])(?=.*[A-ZÀÂÄÉÈÊËÏÎÔÖÙÛÜŸÇ])(?=.*\d)(?=.*[@#!%*$€£?§&-])[A-Za-zàâäéèêëïîôöùûüÿçÀÂÄÉÈÊËÏÎÔÖÙÛÜŸÇ\d@#!%*$€£?§&-]{8,60}$/)
  }

  // If error, the 'type' attribute of the button is set to 'button', else 'submit'
  if (!(isFieldValid.email && isFieldValid.password)) {
    buttonSubmit.setAttribute('type', 'button')
  } else {
    buttonSubmit.setAttribute('type', 'submit')
  }
})