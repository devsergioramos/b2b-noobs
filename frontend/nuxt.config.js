import colors from 'vuetify/es5/util/colors'

export default {
  // Global page headers (https://go.nuxtjs.dev/config-head)
  head: {
    titleTemplate: process.env.PROJECT_NAME,
    title: process.env.PROJECT_NAME,
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },
  // Global CSS (https://go.nuxtjs.dev/config-css)
  css: [
  ],

  // Plugins to run before rendering page (https://go.nuxtjs.dev/config-plugins)
  plugins: [
    { src: '~/plugins/vuetify.js' },
  ],

  // Auto import components (https://go.nuxtjs.dev/config-components)
  components: true,

  // Modules for dev and build (recommended) (https://go.nuxtjs.dev/config-modules)
  buildModules: [
    // https://go.nuxtjs.dev/vuetify
    '@nuxtjs/vuetify',
    '@nuxtjs/dotenv'
  ],

  // Modules (https://go.nuxtjs.dev/config-modules)
  modules: [
    '@nuxtjs/pwa',
    ['@nuxtjs/axios', {
      requestInterceptor (config) {
        config.headers.common['Content-Type'] = 'multipart/form-data;'
        return config
      }
    }],
    '@nuxtjs/proxy',
    '@nuxtjs/toast',
    '@nuxtjs/auth',
    '@nuxt/http'
  ],

  /* Vuetify module configuration (https://go.nuxtjs.dev/config-vuetify)
  vuetify: {
    customVariables: ['~/assets/variables.scss'],
    theme: {
      dark: true,
      themes: {
        dark: {
          primary: colors.blue.darken2,
          accent: colors.grey.darken3,
          secondary: colors.amber.darken3,
          info: colors.teal.lighten1,
          warning: colors.amber.base,
          error: colors.deepOrange.accent4,
          success: colors.green.accent3
        }
      }
    }
  },*/
  pwa: {
    manifest: {
      name: process.env.PROJECT_NAME,
      short_name: 'Nuxt.js PWA',
      start_url: '/',
      theme_color: '#424242',
      display: 'standalone',
    },
    icon: {
      iconSrc: './static/favicon.ico',
    },
  },
  // Build Configuration (https://go.nuxtjs.dev/config-build)
  build: {
  },
  axios: {
    /* set API_URL environment variable to configure access to the API
    */
    baseURL: process.env.URL_API,
    redirectError: {
      404: '/notfound'
    }
  },
  proxy: {
    '/api': {
      target: process.env.URL_API,
      pathRewrite: {
        '^/api' : '/'
      },changeOrigin: true
    }
  },
  auth: {
    strategies: {
      local: {
        endpoints: {
          login: { url: '/api/login', method: 'post', propertyName: 'token' },
          logout: { url: '/api/logout', method: 'get' },
          user: { url: 'api/user', method: 'get', propertyName: 'data' }
        },
        //tokenRequired: true,
        tokenType: ''
      }
    },
    redirect: {
      login: '/login',
      logout: '/login',
      user: '/profile',
      home: false
    }
  },
}
