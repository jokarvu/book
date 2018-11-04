import VueRouter from 'vue-router'

// Layouts
import App from './components/layouts/app'
import NotFoundPage from './components/NotFoundPage'
import Login from './components/login'

// Pages
import Dashboard from './components/pages/dashboard'
// User
import UserIndex from './components/pages/user/index'
import UserCreate from './components/pages/user/create'
import UserUpdate from './components/pages/user/edit'
import UserShow from './components/pages/user/show'

const routes = [
    {
        path: '/login',
        component: Login,
        beforeEnter: (to, from, next) => {
            return axios.get('/auth/check').then(response => {
                return next({path: '/'});
            }).catch(errors => {
                return next()
            })
        }
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
            {path: 'dashboard', component: Dashboard},
            {path: 'user', component: UserIndex},
            {path: 'user/create', component: UserCreate},
            {path: 'user/:slug/edit', component: UserUpdate, name: 'UserUpdate'},
            {path: 'user/:slug', component: UserShow, name: 'UserShow'},
        ]
    },
    // Not Found Page
    {path: '*', component: NotFoundPage},
]

const router = new VueRouter({
    routes: routes,
    mode: 'history',
    linkExactActiveClass: 'active',
    linkActiveClass: 'active',
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(m => m.meta.auth)) {
        return axios.get('/auth/check').then(authenticated => {
            if(authenticated.data != 'true') {
                return next({path: '/login'})
            }
            if(to.matched.some(m => m.meta.admin)) {
                return axios.get('/auth/admin').then(role => {
                    if(role.data == 'true') {
                        return next();
                    }
                    return next({path: '/NotFoundPage'})
                })
            }
            return next();
        }).catch(errors => {
            return next({path: '/login'})
        })
    }
    return next()
});

export default router