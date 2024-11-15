window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
$(document).ready(function () {
    /**
     * Next we will register the CSRF Token as a common header with Axios so that
     * all outgoing HTTP requests automatically have it attached. This is just
     * a simple convenience so we don't have to attach every token manually.
     */

    const token = document.head.querySelector('meta[name="csrf-token"]');

    if (token) {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    } else {
        console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
    }
});


import { createApp } from 'vue'
import Login from './login/Login.vue'

createApp(Login).mount('#app_login')
