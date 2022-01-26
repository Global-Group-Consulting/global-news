
window.addEventListener("DOMContentLoaded", function () {
  const formsList = document.querySelectorAll('form')
  
  formsList.forEach(form => {
    form.addEventListener("submit", function (e) {
      if (this.submitting) {
        e.preventDefault();
        return;
      }
      
      const submitButton = this.querySelector("[type='submit']");
      const cancelButton = this.querySelector("[type='reset']");
      const loadingSpinner = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>`;
      
      this.submitting = true;
      
      submitButton.disabled = true;
      submitButton.classList.add("disabled");
      submitButton.innerHTML = loadingSpinner + submitButton.innerHTML
      
      if (cancelButton) {
        cancelButton.classList.add("disabled");
        cancelButton.disabled = true
      }
    })
  })
})
