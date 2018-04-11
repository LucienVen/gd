import Vue from 'vue'
// 引入vuex
import Vuex from 'vuex';
Vue.use(Vuex);

const state = {
  selectCityVal: '',
  transDict: [{
      'name': 'xiamen',
      'transName': '厦门'
    },
    {
      'name': 'guangzhou',
      'transName': '广州'
    },

    {
      'name': 'chengdu',
      'transName': '成都'
    },
  ]
}


const mutations = {
  storeSelectedCity(state, city) {
    state.selectCityVal = city

  }
}


export default new Vuex.Store({
  state,mutations
})
