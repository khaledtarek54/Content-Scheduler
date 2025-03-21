import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router' // Ensure it's WebHistory
import { createPinia } from 'pinia'
import App from './App.vue'
import Login from './pages/Login.vue'
import Register from './pages/Register.vue'
import Dashboard from './pages/Dashboard.vue'
import { useAuthStore } from './store/auth'
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import '../css/app.css';
import axios from 'axios'

// Set Laravel API Base URL
axios.defaults.baseURL = 'http://127.0.0.1:8000/api'

const token = localStorage.getItem('token')
if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
}

const routes = [
    { path: '/login', component: Login },
    { path: '/register', component: Register },
    { 
        path: '/dashboard', 
        component: Dashboard, 
        meta: { requiresAuth: true } 
    },
    { path: '/:pathMatch(.*)*', redirect: '/login' }
]

const router = createRouter({
    history: createWebHistory(), 
    routes
})

// Protect Routes
router.beforeEach(async (to, from, next) => {
    const auth = useAuthStore()
    await auth.fetchUser()

    if (to.meta.requiresAuth && !auth.user) {
        next('/login')
    } else {
        next()
    }
})

const app = createApp(App)
app.use(Toast)
app.use(router)
app.use(createPinia())
app.mount('#app')
