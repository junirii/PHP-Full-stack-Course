import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Map from '../views/Map.vue'
import Calender from '../views/Calender.vue'
import Option from '../views/Option.vue'
import List from '../views/List.vue'

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
]//dasgsdgsdgasdg

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
