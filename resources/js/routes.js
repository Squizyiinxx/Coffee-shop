import Home from './pages/Home.vue';
import Pesanan from './pages/PesananComponent.vue'


export const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
    },
    {
        path: '/pesanan',
        name: 'pesanan',
        component: Pesanan,
    },

   
]
