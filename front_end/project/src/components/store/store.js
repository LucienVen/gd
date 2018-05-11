import Vue from 'vue'
// 引入vuex
import Vuex from 'vuex';
Vue.use(Vuex);

// import axios from 'axios'


// 设置account模块组



// 设置全局变量
const state = {

  // 用户信息
  uid: '',
  email: '',
  username: '',
  // -------------------------
  // 景点列表
  testPlanRes: '',
  // 推荐景点
  recommondViewPoint: '',
  // -------------------------

  // 选择出发城市
  beginCity: '',

  // 选择展示日期
  showDay: '0',
  moveCity: '',
  showDayTime: '',
  // showDayCity: '',

  // test
  // heatMapData: [],
  
  // 用户选择
  personalChoose: [],
  // 选择列车班次
  selectTrainSchedule: '',
  // 是否票务查询
  isTicketingInquiry: '',
  // 选择出行方式
  travelMode: '',
  // 出现日程选择
  schedule: '',
  // 选择行程舒适度
  travelComfort: '',
  //   选择酒店类型
  hotelType: '',
  // 选择出行城市
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
  // 选择景点类型
  selectType: '',


  //   selectPointTypeList: [],
  //   recommendPointTypeList: []

  // 模态框
  diaTitle: "",
  // 地图刷新, 记录地图当前显示值
  mapReflash: '',
}

// 设置同步方法
const mutations = {

  // 用户信息
  storeUid(state, uid){
    state.uid = uid
  },
  storeEmail(state, email){
    state.email = email
  },
  storeUserName(state, username) {
    state.username = username
  },

  // recommondViewPoint推荐景点信息
  storeRecommondViewPoint(state, recommondViewPoint){
    state.recommondViewPoint = recommondViewPoint
  },






  // 重置
  reset(state) {
    // 选择列车班次
    state.selectTrainSchedule = ''

    // 是否票务查询
    state.isTicketingInquiry = ''
    // 选择出行方式
    state.travelMode = ''
    // 出现日程选择
    state.schedule = ''
    // 选择行程舒适度
    state.travelComfort = ''
    //   选择酒店类型
    state.hotelType = ''
    // 选择出行城市
    state.selectCityVal = ''
    // 选择出发chengs
    state.beginCity = ''
    // 选择景点类型
    state.selectType = ''
  },


  storeTestPlanRes(state, testPlanRes) {
    state.testPlanRes = testPlanRes
  },



  // HeatMap
  // storeSetHeatMapData(state, heatMapData){
  //   state.heatMapData = heatMapData
  // },

  // updateUserInfo
  updateUserInfo(state, newUserInfo) {
    state.userInfo = newUserInfo;
  },

  // 更新模态框标题
  storeSelectDiaTitle(state, diaTitle) {
    state.diaTitle = diaTitle;
  },


  storeSelectedCity(state, city) {
    state.selectCityVal = city;
  },
  storeSelectType(state, typeList) {
    state.selectType = typeList;
  },
  // 更新现在行程舒适度
  storeTravelComfort(state, travelComfort) {
    state.travelComfort = travelComfort;
  },
  // 更新出现日程
  storeSchedule(state, schedule) {
    state.schedule = schedule
  },
  storeTravelMode(state, travelMode) {
    state.travelMode = travelMode
  },
  storeIsTicketingInquiry(state, isTicketingInquiry) {
    state.isTicketingInquiry = isTicketingInquiry
  },
  // selectTrainSchedule
  storeTrainSchedule(state, selectTrainSchedule) {
    state.selectTrainSchedule = selectTrainSchedule
  },
  // 酒店类型
  storeHotelType(state, hotelType) {
    state.hotelType = hotelType
  },
  // 更新选择展示日期行程
  storeShowDay(state, showDay) {
    state.showDay = showDay
    // state.showDayCity = showDayCity
  },
  
  
  storeShowDayTime(state, showDayTime) {
    state.showDayTime = showDayTime
  },
  storeMoveCity(state, moveCity) {
    state.moveCity = moveCity
  },



  // 更新出发城市
  storeBeginCity(state, beginCity) {
    state.beginCity = beginCity
  }
}

// 设置获取过滤
const getters = {
  // 出发城市代号-名称转化n
  // storeCityCode2Name(state){
  //   let cityCode = state.beginCity
  // },
  // storeRecommendType: function (state) {},
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

// const actions = {
//   getHeatMapDate({commit}){
//     axios
//       .get(
//         'http://localhost:8089/gd/back_end/public/index.php/v1/destination/heatmap'
//       )
//       .then(response => {
//         console.log(response.data.data);

//         commit('storeSetHeatMapData', response.data.data)
//       })
//       .catch(error => {
//         console.log(error)
//       })
//   }
// }

// 导出
export default new Vuex.Store({
  state,
  mutations,
  getters,
  // actions
  // modules: { account: accountModule }
})
