import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'

import Home from '@/components/Home'
// import Demo from '@/components/page/Demo'

import Plan from '@/components/page/Plan'
import ResultTravel from '@/components/page/ResultTravel'
import BaiduMap from '@/components/page/BaiduMap'


Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
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
