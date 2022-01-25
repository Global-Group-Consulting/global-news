window.addEventListener("DOMContentLoaded", function () {
  const deleteModal = document.getElementById("deleteModal");
  
  if (!deleteModal) {
    return
  }
  
  deleteModal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
    const button = event.relatedTarget
    
    // Extract info from data-bs-* attributes
    const id = button.dataset.bsId
    const form = this.querySelector('form')
    
    form.action = form.action.replace("_id", id)
  })
})
