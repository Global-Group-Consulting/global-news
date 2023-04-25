
require('./bootstrap');
require('./dropdowns');
require('./modals');
require('./forms');

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
  } catch (e) {
    console.log(e)
  }
})
