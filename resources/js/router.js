import VueRouter from 'vue-router'

// ADMINISTRATOR
// Layouts
import App from './admin/components/layouts/app'
import NotFoundPage from './admin/components/NotFoundPage'
import Login from './admin/components/login'
import Render from './admin/components/render'

// Pages
import Dashboard from './admin/components/pages/dashboard'
// User
import UserIndex from './admin/components/pages/user/index'
import UserCreate from './admin/components/pages/user/create'
import UserUpdate from './admin/components/pages/user/edit'
import UserShow from './admin/components/pages/user/show'
// Book
import BookIndex from './admin/components/pages/book/index'
import BookCreate from './admin/components/pages/book/create'
import BookShow from './admin/components/pages/book/show'
import BookUpdate from './admin/components/pages/book/edit'
// Category
import CategoryIndex from './admin/components/pages/category/index'
import CategoryCreate from './admin/components/pages/category/create'
import CategoryShow from './admin/components/pages/category/show'
import CategoryUpdate from './admin/components/pages/category/edit'
// Invoice
import InvoiceIndex from './admin/components/pages/invoice/index'
import InvoiceShow from './admin/components/pages/invoice/show'
import InvoiceCreate from './admin/components/pages/invoice/create'
// Import
import ImportIndex from './admin/components/pages/imports/index'
import ImportCreate from './admin/components/pages/imports/create'



// CUSTOMER
import Customer from './customer/components/layouts/customer'
import Index from './customer/components/pages/index'
import Category from './customer/components/pages/category'
import Cart from './customer/components/pages/cart'

const routes = [
    {
        path: '/login',
        component: Login,
        beforeEnter: (to, from, next) => {
            return axios.get('/auth/check').then(response => {
                return window.location.replace('http://book.com');
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
            // User pages
            {path: 'user', component: UserIndex},
            {path: 'user/create', component: UserCreate},
            {path: 'user/:slug', component: UserShow, name: 'UserShow'},
            {path: 'user/:slug/edit', component: UserUpdate, name: 'UserUpdate'},
            // Book pages
            {path: 'book', component: BookIndex},
            {path: 'book/create', component: BookCreate},
            {path: 'book/:slug', component: BookShow, name: 'BookShow'},
            {path: 'book/:slug/edit', component: BookUpdate, name: 'BookUpdate'},
            // Category pages
            {path: 'category', component: CategoryIndex},
            {path: 'category/create', component: CategoryCreate},
            {path: 'category/:slug', component: CategoryShow, name: 'CategoryShow'},
            {path: 'category/:slug/edit', component: CategoryUpdate, name: 'CategoryUpdate'},
            // Invoice pages
            {path: 'invoice', component: InvoiceIndex},
            {path: 'invoice/create', component: InvoiceCreate},
            {path: 'invoice/:id', component: InvoiceShow, name: 'InvoiceShow'},
            // Import page
            {path: 'import', component: ImportIndex},
            {path: 'import/create', component: ImportCreate},
        ]
    },
    {
        path: '/',
        component: Customer,
        redirect: '/index.html',
        children: [
            {path: 'index.html', component: Index},
            {path: 'cart', component: Cart},
            {path: ':slug', component: Category, name: 'Category'},
        ]
    },
    // Not Found Page
    {path: '/render', component: Render},
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