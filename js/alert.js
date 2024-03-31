const alertPlaceholder = document.querySelector('.liveAlertPlaceholder')
const alertForm = document.querySelector('form')
const alertTriggers = document.querySelectorAll('.liveAlertBtn')

const appendAlert = (message, type) => {
  const wrapper = document.createElement('div')
  wrapper.innerHTML = [
    `<div class="alert alert-${type} alert-dismissible" role="alert">`,
    `   <div>${message} </div>`,
    '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
    '</div>'
  ].join('')

  alertPlaceholder.appendChild(wrapper)
}

alertTriggers.forEach((alertTrigger, index) => {
  alertTrigger.dataset.index = index
  alertTrigger.addEventListener('click', () => {
    // Disable the button
    alertTrigger.disabled = true
    alertForm.submit()

    appendAlert('Orderd Successfully', 'success', alertTrigger.dataset.index)
    alert("Orderd Successfully");
    
    // alertTriggers.style.display="none"
    setTimeout(() => {
      // Hide the alert box
      alertPlaceholder.lastChild.remove()
      alertTrigger.disabled = false
    }, 1000)
  })
})