import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import List from '../views/List.vue';
import Detail from '../views/Detail.vue';
import Create from '../views/Create.vue';
import Create_Ctnt from '../views/Create_Ctnt.vue';
import MyPage from '../views/MyPage.vue';
import SelectPage from '../views/SelectPage.vue';
import store from '@/store';
import MyAccount from '../views/MyAccount.vue';
import MyAccountMod from '../views/MyAccountMod.vue';
import Chat from '../views/Chat.vue';

//네이게이션 가드 commit test
const requireAuth = () => (to, from, next) => {
  if(!store.state.user.iuser) {
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
    component: MyPage,
    beforeEnter: requireAuth(),
  },
  {
    path: '/myaccount',
    name: 'myaccount',
    component: MyAccount,
    beforeEnter: requireAuth()
  },
  {
    path: '/create_ctnt',
    name: 'create_ctnt',
    component: Create_Ctnt,
    beforeEnter: requireAuth()
  },
  {
    path: '/myaccountmod',
    name: 'myaccountmod',
    component: MyAccountMod,
    beforeEnter: requireAuth()
  },
  {
    path: '/chat',
    name: 'chat',
    component: Chat,
    beforeEnter: requireAuth()
  },
]
const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
