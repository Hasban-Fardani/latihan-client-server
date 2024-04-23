import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

import axios from 'axios'

import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap'
import 'bootstrap-icons/font/bootstrap-icons.min.css'

axios.defaults.baseURL = 'http://localhost:8000'

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.mount('#app')
