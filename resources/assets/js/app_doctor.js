require('./bootstrap');

import { createApp } from 'vue'
import App from './doctor/App.vue'

const app = createApp(App)
app.mount('#app_doctor')