import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import mixins from './mixins';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import '../../static/css/common.css';
import '@fortawesome/fontawesome-free/js/all.js'
// import map from '/raphael_min.js'
// import raphael from '/raphael_min.js'

createApp(App)
.mixin(mixins)
.use(store)
.use(router)
.use(VueSweetalert2)
// .use(map)
// .use(raphael)
.mount('#app');