import Vue from 'vue'
import Router from 'vue-router'
import { normalizeURL } from '@nuxt/ufo'
import { interopDefault } from './utils'
import scrollBehavior from './router.scrollBehavior.js'

const _f80abc42 = () => interopDefault(import('../pages/categorias.vue' /* webpackChunkName: "pages/categorias" */))
const _131068a5 = () => interopDefault(import('../pages/dashboard.vue' /* webpackChunkName: "pages/dashboard" */))
const _7c425849 = () => interopDefault(import('../pages/logout.vue' /* webpackChunkName: "pages/logout" */))
const _047d9d99 = () => interopDefault(import('../pages/produtos.vue' /* webpackChunkName: "pages/produtos" */))
const _a90a073a = () => interopDefault(import('../pages/index.vue' /* webpackChunkName: "pages/index" */))

// TODO: remove in Nuxt 3
const emptyFn = () => {}
const originalPush = Router.prototype.push
Router.prototype.push = function push (location, onComplete = emptyFn, onAbort) {
  return originalPush.call(this, location, onComplete, onAbort)
}

Vue.use(Router)

export const routerOptions = {
  mode: 'history',
  base: '/',
  linkActiveClass: 'nuxt-link-active',
  linkExactActiveClass: 'nuxt-link-exact-active',
  scrollBehavior,

  routes: [{
    path: "/categorias",
    component: _f80abc42,
    name: "categorias"
  }, {
    path: "/dashboard",
    component: _131068a5,
    name: "dashboard"
  }, {
    path: "/logout",
    component: _7c425849,
    name: "logout"
  }, {
    path: "/produtos",
    component: _047d9d99,
    name: "produtos"
  }, {
    path: "/",
    component: _a90a073a,
    name: "index"
  }],

  fallback: false
}

function decodeObj(obj) {
  for (const key in obj) {
    if (typeof obj[key] === 'string') {
      obj[key] = decodeURIComponent(obj[key])
    }
  }
}

export function createRouter () {
  const router = new Router(routerOptions)

  const resolve = router.resolve.bind(router)
  router.resolve = (to, current, append) => {
    if (typeof to === 'string') {
      to = normalizeURL(to)
    }
    const r = resolve(to, current, append)
    if (r && r.resolved && r.resolved.query) {
      decodeObj(r.resolved.query)
    }
    return r
  }

  return router
}
