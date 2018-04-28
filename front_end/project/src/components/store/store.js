import Vue from 'vue'
// 引入vuex
import Vuex from 'vuex';
Vue.use(Vuex);

// import axios from 'axios'

// 设置全局变量
const state = {
  // test
  // heatMapData: [],
  scenicRecommond: [
    {
      'name': '钟鼓索道',
      'location': '厦门市思明区虎园路31号(老人活动中心对面)',
      'type': '缆车/索道',
      'play_time': '建议0.5小时',
      'photo_url': 'https://dimg06.c-ctrip.com/images/100m0p000000fvny75481_C_350_230.jpg',
      'score': 3
    },
    
    {
      'name': '白城沙滩',
      'location': '厦门市思明区大学路',
      'type': '海滨/沙滩',
      'play_time': '建议2-3小时',
      'photo_url': 'https://dimg02.c-ctrip.com/images/fd/tg/g2/M0A/8F/0B/CghzgFWxE5aAN73IAAkUQA9R1yw015_C_350_230.jpg',
      'score': 4.4
    },
    {
      'name': '厦门大学',
      'location': '厦门市思明区思明南路422号',
      'type': '学府',
      'play_time': '建议3小时',
      'photo_url': 'https://dimg09.c-ctrip.com/images/fd/tg/g3/M02/62/93/CggYGVX45_qAAASLABNoVZUVZTM247_C_350_230.jpg',
      'score': 5
    }
  ],

  // 静态出行日期数据
  travelDateList:[
    {
      'day': 1,
      'travelDate': '5月1日',
      'from_city': '广州',
      'to_city': '厦门',
    },
    {
      'day': 2,
      'travelDate': '5月2日',
      'from_city': null,
      'to_city': '厦门',
    },
    {
      'day': 3,
      'travelDate': '5月3日',
      'from_city': '厦门',
      'to_city': '广州',
    }
  ],

  // 静态景点数据
  scenicData: [
    {
      'name': '鼓浪屿',
      'location': '厦门市思明区鼓浪屿',
      'type': '岛屿/半岛世界文化遗产',
      'level': 5,
      'play_time': '建议2天',
      'detail':'鼓浪屿是个宁静美丽的小岛，这里有着各种风格迥异、中西合壁的建筑，汇集了各种特色的食铺和商铺，充满了文艺范儿。2017年7月8日，在波兰克拉科夫举行的第41届世界遗产大会上，鼓浪屿申遗成功，成为中国第52项世界遗产。第一次上岛的游客，建议购买鼓浪屿联票，可以把岛上主要景点一次玩个遍。你可以顺着套票上的景点一个个往下走，套票包括的景点有：可以俯视全岛的日光岩、堪称江南古典园林精品的菽庄花园（含钢琴博物馆）、明代风格建筑的皓月园（内有郑成功石像）、风琴博物馆和国际刻字艺术馆等。除外，鼓浪屿上还有闽南建筑风格的海天堂构及中完合壁的八卦楼，以及19世纪欧陆风格的原西方国家领事馆，正因为其多种建筑风格，所以鼓浪屿又有万国建筑博览之称。',
      'open_time': '全天开放，内部景点开放时间不一，可电话咨询。',
      'ticket_msg': '免费开放。内部景点需要门票',
      'photo_url': 'https://dimg05.c-ctrip.com/images/fd/tg/g3/M01/F7/4B/CggYGlYBGgSAHV55ABimumb0Nmw520_C_350_230.jpg'
    }
  ],


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
  ],

  //   selectPointTypeList: [],
  //   recommendPointTypeList: []

  // 模态框
  diaTitle: "",
}

// 设置同步方法
const mutations = {

  // HeatMap
  // storeSetHeatMapData(state, heatMapData){
  //   state.heatMapData = heatMapData
  // },

  // 更新模态框标题
  storeSelectDiaTitle(state, diaTitle){
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
})
