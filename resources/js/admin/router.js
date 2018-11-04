import VueRouter from 'vue-router'

// Layouts
import App from './components/layouts/app'
import NotFoundPage from './components/NotFoundPage'
import Login from './components/login'

// Pages
import Dashboard from './components/pages/dashboard'

const routes = [
    {
        path: '/login',
        component: Login,
    },
    {
        path: '/admin',
        component: App,
        redirect: '/admin/dashboard',
        meta: {
            auth: true,
            admin: true
        }, 
        children: [
            {path: 'dashboard', component: Dashboard}
        ]
    },
    // Not Found Page
    {path: '*', component: NotFoundPage},
]

const router = new VueRouter({
    routes: routes,
    mode: 'history',
    linkExactActiveClass: 'active'
});

export default router