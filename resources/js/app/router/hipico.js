

import E404 from '../pages/errors/404.vue'
import E401 from '../pages/errors/401.vue'
import hipodromos from '../pages/hipodromos/Main.vue'
import ponles from '../pages/ponles/Main.vue'
import currency from '../pages/currency/Main.vue'
import paymentMethods from '../pages/paymentMethods/Main.vue'

import users from '../pages/users/Main.vue'
import usersDetail from '../pages/users/Detail.vue'
import jornadas from '../pages/jornadas/Main.vue'
import Detail from '../pages/jornadas/Detail.vue'
import posos from '../pages/posos/Main.vue'
import bankUsers from '../pages/bankUsers/Main.vue'

import Dashboard from '../pages/dashboard/Index.vue'
import Verify from '../pages/users/Verify.vue'

import Terminos from '../pages/terminos/Index.vue'
import Suggestions from '../pages/suggestions/Main.vue'

import Tercios from '../pages/jornadas/modulesTercios/Detail.vue';
import DetailPolla from '../pages/jornadas/modulesPolla/Detail.vue';

export default [ 
    
    {
        path: '/suggestions',
        name: "suggestions",
        component: Suggestions
    },
    {
        path: '/terminos',
        name: "terminos",
        component: Terminos
    },
    {
        path: '/user/bank',
        name: "bank-user",
        component: bankUsers
    },
    {
        path: '/user/verify/:id/:user',
        name: "verify",
        component: Verify
    },
    {
        path: '/',
        name: "home",
        component: Dashboard
    },
    {
        path: '/jornadas',
        name: "jornadas",
        component: jornadas
    },
    {
        path: '/jornada-detail/:id',
        name: "jornadas-detail",
        component: Detail
    },
    {
        path: '/tercio-detail/:id',
        name: "tercio-detail",
        component: Tercios
    },
    {
        path: '/polla-detail/:id',
        name: "polla-detail",
        component: DetailPolla
    },
    {
        path: '/users',
        name: "users",
        component: users
    },
    {
        path: '/user-detail/:id',
        name: "user-detail",
        component: usersDetail
    },
    {
        path: '/hipodromos',
        name: "hipodromos",
        component: hipodromos
    },
    {
        path: '/ponles',
        name: "ponles",
        component: ponles
    },
    {
        path: '/currency',
        name: "currency",
        component: currency
    },
    {
        path: '/payment-methods',
        name: "payment-methods",
        component: paymentMethods
    },
    {
        path: '/posos',
        name: "posos",
        component: posos
    },
    { 
        path: '*', 
        component: E404
    },
    { 
        path: '/unauthorized', 
        component: E401
    }
   
];