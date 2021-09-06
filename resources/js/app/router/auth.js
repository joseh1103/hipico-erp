import login from '../pages/auth/login.vue'
import register from '../pages/auth/register.vue'
import passwordEmail from '../pages/auth/password/email.vue'
import reset from '../pages/auth/password/reset.vue'
import verify from '../pages/auth/verification/verify.vue'
import resend from '../pages/auth/verification/resend.vue'

export default [
  {
    path: '/login',
    name: "login",
    component: login
  },
  {
    path: '/register',
    name: "register",
    component: register
  },
  {
    path: '/password/reset',
    name: "passwordReset",
    component: passwordEmail
  },
  {
    path: '/password/reset/:token',
    name: "password.reset",
    component: reset
  },
  {
    path: '/email/verify/:id',
    name: "verification.verify",
    component: verify
  },
  {
    path: '/email/resend',
    name: "verification.resend",
    component: resend
  }
]
