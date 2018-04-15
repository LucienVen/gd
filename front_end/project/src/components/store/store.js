import Vue from 'vue'
// 引入vuex
import Vuex from 'vuex';
Vue.use(Vuex);


// 设置全局变量
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
  selectType: [],

  // 静态票价
  ticketMsg: [{
      'end_time': '08:05',
      'from_station': '广州东',
      'is_same_day': '隔日抵达',
      'seat': {
        '硬座': '¥130.0',
        '软卧': '¥340.0',
        '硬卧': '¥222.0',
        '无座': '¥130.0'
      },

      'seat_type': '1413',
      'start_time': '20:42',
      'station_no': {
        'from_s_no': '01',
        'to_s_no': '16'
      },
      'status': '1',
      'take_time': '11:23',
      'to_station': '厦门',
      'train': 'K297',
      'train_code': '650000K2970D'
    },
    {
      'end_time': '08:05',
      'from_station': '广州南',
      'is_same_day': '当天抵达',
      'seat': {
        '硬座': '¥130.0',
        '软卧': '¥340.0',
        '硬卧': '¥222.0',
        '无座': '¥130.0'
      },


      'seat_type': '1413',
      'start_time': '20:42',
      'station_no': {
        'from_s_no': '01',
        'to_s_no': '16'
      },
      'status': '1',
      'take_time': '11:23',
      'to_station': '厦门',
      'train': 'K297',
      'train_code': '650000K2970D'
    }
  ]

  //   selectPointTypeList: [],
  //   recommendPointTypeList: []


}

// 设置同步方法
const mutations = {
  storeSelectedCity(state, city) {
    state.selectCityVal = city;
  },
  storeSelectType(state, typeList) {
    state.selectType = typeList;
  }
}

// 设置获取过滤
const getters = {
  storeRecommendType: function (state) {},
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


// 导出
export default new Vuex.Store({
  state,
  mutations,
  getters
})
