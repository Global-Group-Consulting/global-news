/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')
require('./dropdowns')
require('./modals')
require('./forms')

require('tinymce/tinymce.min')
require('tinymce/plugins/image')
require('tinymce/plugins/link')
require('tinymce/plugins/media')
require('tinymce/themes/silver')
require('tinymce/models/dom')
require('tinymce/icons/default')

window.Vue = require('vue').default

window.addEventListener('DOMContentLoaded', function () {
  tinymce.init({
    selector: 'textarea.tinymce',
    skin_url: '/skins/ui/oxide/',
    content_css: '/skins/content/default/content.min.css',
    statusbar: false,
    promotion: false,
    plugins: 'image link media',
    toolbar: 'image link media',
    image_advtab: true,
    image_title: true,
    image_uploadtab: true,
    images_file_types: 'jpg,jpeg,png,gif,webp',
    image_prepend_url: window.FILE_APP_URL + "/files/",
    images_upload_url: window.FILE_APP_URL + "/api/wysiwyg",
    // images_upload_credentials: true
  })
})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('multiselect', require('vue-multiselect').default)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
  el: '#app'
})
