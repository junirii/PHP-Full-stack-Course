import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
// import SelectPage from '../views/SelectPage.vue';
import Map from '../views/Map.vue';
import Calender from '../views/Calender.vue';
import Option from '../views/Option.vue';
import List from '../views/List.vue';
import Detail from '../views/Detail.vue';
import Create from '../views/Create.vue';
import Mypage from '../views/Mypage.vue';
import SelectPage from '../views/SelectPage.vue';
import store from '@/store';
import Myaccount from '../views/Myaccount.vue'
import MyaccountMod from '../views/Myaccountmod.vue'

//네이게이션 가드
const requireAuth = () => (to, from, next) => {
  if(store.state.user.iuser === undefined) {
    swal.fire('로그인을 하세요.', '', 'warning');
    return;
  }
  next();
}

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/selectpage',
    name: 'selectpage',
    component: SelectPage,
    beforeEnter: requireAuth()
  },
  {
    path: '/map',
    name: 'map',
    component: Map,
    beforeEnter: requireAuth()
  },
  {
    path: '/calender',
    name: 'calender',
    component: Calender,
    beforeEnter: requireAuth()
  },
  {
    path: '/option',
    name: 'option',
    component: Option,
    beforeEnter: requireAuth()
  },
  {
    path: '/list',
    name: 'list',
    component: List,
    beforeEnter: requireAuth()
  },
  {
    path: '/detail',
    name: 'detail',
    component: Detail,
    beforeEnter: requireAuth()
  },
  {
    path: '/create',
    name: 'create',
    component: Create,
    beforeEnter: requireAuth()
  },
  {
    path: '/mypage',
    name: 'mypage',
    component: Mypage,
    beforeEnter: requireAuth(),
  },
  {
    path: '/myaccount',
    name: 'myaccount',
    component: Myaccount,
    beforeEnter: requireAuth()
  },
  {
    path: '/myaccountmod',
    name: 'myaccountmod',
    component: MyaccountMod,
    beforeEnter: requireAuth()
  }
]
const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
