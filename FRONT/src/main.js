import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import mixins from './mixins';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import socketPlugin from "./plugins/socketPlugin";
import '../../static/css/common.css';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
// import selectPage from '../../static/js/selectPage.js';
// import '@fortawesome/fontawesome-free/js/all.js';


createApp(App)
.mixin(mixins)
.use(store)
.use(router)
.use(Datepicker)
.use(VueSweetalert2)
.use(socketPlugin)
// .use(selectPage)
.mount('#app');