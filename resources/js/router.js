import { createRouter, createWebHistory } from 'vue-router'


import DefaultHeader from '@layout/Header.vue'
import DefaultAside from '@layout/MainAside.vue'

import Login from '@/components/auth/Login.vue'

import Main from '@/components/MainPage.vue'

const routes = [
  // {
  //   path: '/:pathMatch(.*)*',
  //   name: 'not-found',
  //   components: {
  //     default: NotFound
  //   }
  // },
  {
    path: '',
    name: 'main',
    components: { aside: DefaultAside, header: DefaultHeader, default: Main },
    meta: { auth: true, menuitem: '0' },
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta: { auth: false, menuitem: '1' },
  },
]

const router = createRouter({
  history: createWebHistory('/panel'),
  routes,
})
router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.auth)) {
    if (!window.$identity.isGuest) {
      next()
      return
    }
    next({
      path: '/login',
      query: { redirect: to.fullPath },
    })
  } else {
    next()
  }
})

//  Fix error NavigationDuplicated second option
const originalPush = createRouter.push
// eslint-disable-next-line func-names
createRouter.push = function push(location) {
  return originalPush.call(this, location).catch((err) => {
    if (err.name !== 'NavigationDuplicated') throw err
  })
}

export default router
