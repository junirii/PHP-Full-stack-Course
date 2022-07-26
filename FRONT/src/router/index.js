import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Map from '../views/Map.vue'
import Calender from '../views/Calender.vue'
import Option from '../views/Option.vue'
import List from '../views/List.vue'
import Create from '../views/Create.vue'
import Detail from '../views/Detail.vue'
import Mypage from '../views/Mypage.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/map',
    name: 'map',
    component: Map
  },
  {
    path: '/calender',
    name: 'calender',
    component: Calender
  },
  {
    path: '/option',
    name: 'option',
    component: Option
  },
  {
    path: '/list',
    name: 'list',
    component: List
  },
  {
    path: '/create',
    name: 'create',
    component: Create
  },
  {
    path: '/detail',
    name: 'detail',
    component: Detail
  },
  {
    path: '/mypage',
    name: 'mypage',
    component: Mypage
  },
]//dasgsdgsdgasdg

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
