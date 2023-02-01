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
import { createApp, h } from 'vue'

// window.Vue = require('vue').default

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
    image_prepend_url: window.FILE_APP_URL + '/files/',
    images_upload_url: window.FILE_APP_URL + '/api/wysiwyg'
    // images_upload_credentials: true
  })
})

const app = createApp({})

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => {
  const name = key.split('/').pop().split('.')[0]
  
  app.component(name, files(key).default)
  app.component(name.toLowerCase(), files(key).default)
})

app.mount('#app')


