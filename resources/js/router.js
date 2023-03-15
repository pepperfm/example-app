import { createRouter, createWebHistory } from 'vue-router'


import DefaultHeader from '@layout/Header.vue'
import DefaultAside from '@layout/MainAside.vue'

import Login from '@/components/auth/Login.vue'

import Main from '@/components/MainPage.vue'
import StoreEntity from '@/components/StoreEntity/Form.vue'
import ShowEntity from '@/components/UpdateEntity/Form.vue'

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
    meta: { auth: false, menuitem: '0' },
  },
  {
    path: '/store',
    name: 'store-entity',
      components: { aside: DefaultAside, header: DefaultHeader, default: StoreEntity },
    meta: { auth: true, menuitem: '1' },
  },
  {
      path: '/show',
      name: 'show-entity',
      components: { aside: DefaultAside, header: DefaultHeader, default: ShowEntity },
      meta: { auth: true, menuitem: '2' },
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
