import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import mixins from './mixins'

createApp(App)
.use(router) //미들웨어 쓸 때 use
.mixin(mixins)
.mount('#app')
