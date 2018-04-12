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
  ],

  //   选择意愿游玩的景点类型
  typeList: [{
      id: 4,
      type: '海滨/沙滩',
      value: 75
    },
    {
      id: 1,
      type: "岛屿",
      value: 100
    },
    {
      id: 2,
      type: '现代建筑',
      value: 80
    },
    {
      id: 3,
      type: '历史建筑',
      value: 80
    },

    {
      id: 5,
      type: '城市公园',
      value: 70
    }
  ],
  selectType: []
  //   selectPointTypeList: [],
  //   recommendPointTypeList: []


}


const mutations = {
  storeSelectedCity(state, city) {
    state.selectCityVal = city;
  },
  storeSelectType(state, typeList){
      state.selectType = typeList;
  }
}


const getters = {
    storeRecommendType: function (state) {   
    },
    storeRecPointType(state) {
      let typeList = state.typeList
      //   定义排序规则
      let sortValue = (a, b) => b.value - a.value
      let res = typeList.sort(sortValue)
      //   数组浅拷贝，取前二
      let recTypeList = res.slice(0, 2)
      return recTypeList
    },
    // 获取一般景点类别数组
    storeCommonPointType(states) {
      let typeList = state.typeList
      //   定义排序规则
      let sortValue = (a, b) => b.value - a.value
      let res = typeList.sort(sortValue)
      //   数组浅拷贝，取前二
      let commonTypeList = res.slice(2)
      return commonTypeList
    }


}

export default new Vuex.Store({
  state,
  mutations,
  getters
})
