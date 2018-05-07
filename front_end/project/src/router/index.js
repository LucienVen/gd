import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'

import Home from '@/components/Home'
// import Demo from '@/components/page/Demo'

import Plan from '@/components/page/Plan'
import ResultTravel from '@/components/page/ResultTravel'
import BaiduMap from '@/components/page/BaiduMap'
import Registered from '@/components/Registered'
import Login from '@/components/Login'
import About from '@/components/About'



Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path:'/registered',
      name: 'Registered',
      component: Registered
    },
    {
      path: '/about',
      name: 'About',
      component: About
    },
    {
      path: '/plan',
      name: 'Plan',
      component: Plan
    },
    {
      path: '/plan/resultTravel',
      name: 'ResultTravel',
      component: ResultTravel
    },
    {
      path: '/plan/map',
      name: 'BaiduMap',
      component: BaiduMap
    }

  ]
})
