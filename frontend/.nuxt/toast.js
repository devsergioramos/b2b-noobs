import Vue from 'vue'
import Toasted from 'vue-toasted'

Vue.use(Toasted, {})

const globals = undefined
if(globals) {
  globals.forEach(global => {
    Vue.toasted.register(global.name, global.message, global.options)
  })
}

export default function (ctx, inject) {
  inject('toast', Vue.toasted)
}
