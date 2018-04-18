import Vue from 'vue'
// 引入vuex
import Vuex from 'vuex';
Vue.use(Vuex);


import data_point from './points';

const state = {
    data_point: data_point
}

export default new Vuex.Store({
    state
})