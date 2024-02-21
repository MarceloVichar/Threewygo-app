// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  ssr: false,
  devtools: { enabled: true },
  css: ['~/assets/css/main.css'],
  runtimeConfig: {
    public: {
      apiBaseUrl: process.env.NUXT_PUBLIC_API_BASE,
    },
  },
  modules: [
    '@pinia/nuxt',
    'nuxt-icon',
    'nuxt-lodash',
    'dayjs-nuxt',
  ],
  lodash: {
    prefix: '_',
    prefixSkip: ['string'],
    upperAfterPrefix: false,
  },
  dayjs: {
    locales: ['pt-br'],
    defaultLocale: 'pt-br',
    plugins: ['relativeTime'],
  },
  postcss: {
    plugins: {
      tailwindcss: {},
      autoprefixer: {},
    },
  },
})
