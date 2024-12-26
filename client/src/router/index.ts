import { createRouter, createWebHistory } from 'vue-router'

//Views => Authentication
import ViewRegister from '@/views/auth/ViewRegister.vue'
import ViewBlogs from '@/views/blog/ViewBlogs.vue'
import ViewLogin from '@/views/auth/ViewLogin.vue'

//View => Not Found
import ViewNotFound from '@/views/ViewNotFound.vue'
import ViewVerificationMessage from '@/views/auth/ViewVerificationMessage.vue'
import ViewVerificationLogic from '@/views/auth/ViewVerificationLogic.vue'
import ViewSendResetLink from '@/views/auth/ViewSendResetLink.vue'
import ViewResetLinkSendMessage from '@/views/auth/ViewResetLinkSendMessage.vue'
import ViewPasswordReset from '@/views/auth/ViewPasswordReset.vue'
import ViewPasswordResetSuccessMsg from '@/views/auth/ViewPasswordResetSuccessMsg.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      redirect: '/blogs'
    },
    // Authentication Routes
    {
      path: '/register',
      name: 'Register',
      component: ViewRegister,
      meta: { guest: true }
    },
    {
      path: '/login',
      name: 'Login',
      component: ViewLogin,
      meta: { guest: true }
    },
    {
      path: '/verification-message',
      name: 'Verification Message',
      component: ViewVerificationMessage,
      meta: { guest: true }
    },
    {
      path: '/verify-email',
      name: 'Verification Link',
      component: ViewVerificationLogic,
      meta: { guest: true }
    },
    {
      path: '/password-reset-send',
      name: 'Password Reset Link',
      component: ViewSendResetLink,
      meta: { guest: true }
    },
    {
      path: '/password-reset',
      name: 'Password Reset',
      component: ViewPasswordReset,
      meta: { guest: true }
    },
    {
      path: '/password-reset-message',
      name: 'Password Reset Send Message',
      component: ViewResetLinkSendMessage,
      meta: { guest: true }
    },
    {
      path: '/password-reset-success',
      name: 'Password Reset Success Message',
      component: ViewPasswordResetSuccessMsg,
      meta: { guest: true }
    },
    // Blog Routes
    {
      path: '/blogs',
      name: 'Blogs',
      component: ViewBlogs,
      meta: { requiresAuth: true }
    },
    // Not Found
    {
      path: '/:pathMatch(.*)*',
      name: 'Not Found',
      component: ViewNotFound
    }
  ]
})

router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem('token')

  if (to.meta.requiresAuth && !isAuthenticated) {
    return next({ name: 'Login', query: { redirect: to.fullPath } })
  }

  if (to.meta.guest === true && isAuthenticated) {
    return next({ name: 'Blogs' })
  }

  return next()
})

export default router
