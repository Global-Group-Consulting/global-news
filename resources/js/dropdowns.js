window.addEventListener("DOMContentLoaded", function () {
  const dropdowns = document.querySelectorAll(".form-select[data-bs-toggle='dropdown']");
  const actionButtons = document.querySelectorAll(".dropdown-item[data-dd-action]");
  
  function updateSelectText(el, dropdownMenuCheckboxes) {
    let text = [];
    
    dropdownMenuCheckboxes.forEach(input => {
      if (input.checked) {
        text.push(input.labels[0].textContent.trim());
      }
    })
    
    el.innerHTML = text.length > 0 ? text.join(", ") : "&nbsp;"
  }
  
  dropdowns.forEach(el => {
    const dropdownMenu = el.parentNode.querySelector(".dropdown-menu");
    const dropdownMenuCheckboxes = dropdownMenu.querySelectorAll("input[type='checkbox']");
    const dropdownMenuRadios = dropdownMenu.querySelectorAll("input[type='radio']");
  
    dropdownMenu.addEventListener("change", function (e) {
      updateSelectText(el, dropdownMenuCheckboxes.length > 0 ? dropdownMenuCheckboxes : dropdownMenuRadios)
    })
  
    updateSelectText(el, dropdownMenuCheckboxes.length > 0 ? dropdownMenuCheckboxes : dropdownMenuRadios)
  })
  
  actionButtons.forEach(button => {
    const action = button.dataset.ddAction;
    const dropDown = button.closest(".dropdown-menu");
    const checkboxes = dropDown.querySelectorAll("input[type='checkbox']")
    
    button.addEventListener("click", function (e) {
      checkboxes.forEach(input => {
        let checked = input.checked;
        
        if (action === "none") {
          checked = false
        } else if (action === "all") {
          checked = true
        }
        
        input.checked = checked;
      })
  
      dropDown.dispatchEvent(new CustomEvent("change"))
    })
  })
});
