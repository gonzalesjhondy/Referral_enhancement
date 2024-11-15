window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

function get(url, params, headers) {
    return axios.get(url, { params, headers });
}
  

function deletes(url, params, headers) {
    return axios.delete(url, {
        params,
        headers,
    });
}

function post(url, params, headers) {
    return axios.post(url, params, headers);
}
  

function put(url, params, headers) {
    return axios.put(url, params, headers);
}

export default {
    get,
    deletes,
    post,
    put,
};