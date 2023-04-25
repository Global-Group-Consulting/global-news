const Cookies = require('js-cookie')

window.addEventListener('DOMContentLoaded', function () {
  if (Cookies.get('global-tz')) {
    return
  }
  
  try {
    const tz = Intl.DateTimeFormat().resolvedOptions().timeZone
    
    if (tz) {
      Cookies.set('global-tz', tz, { expires: 365 })
    }
    
    window.location.reload()
  } catch (e) {
    console.log(e)
  }
})
