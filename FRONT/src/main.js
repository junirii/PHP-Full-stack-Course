import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import mixins from './mixins';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
// import VueMaterial from 'vue-material'
// import 'vue-material/dist/vue-material.css'
// import 'vue-material/dist/theme/black-green-light.css'
import Directives from '../plugin/directives'

import io from 'socket.io-client';
const socket = io();

const app = createApp(App);
// app.prototype.$socket = socket;
// app.provide('$socket', socket);
// app.config.globalProperties.$socket = socket;
app.config.productionTip = false;
app
.mixin(mixins)
.use(store)
.use(router)
.use(VueSweetalert2)
// .use(VueMaterial)
.use(Directives)
.use(socket)
.mount('#app');