<template>
  <div id="baiduMap">

    <el-row :gutter="20">
      <el-col :span="6">
        <router-link to="/plan/resultTravel">
          <el-button style="float:left;" type="">标准模式</el-button>
          
        </router-link>
      </el-col>
    </el-row>
    <el-row :gutter="20" style="margin-top: 10px;">

      <el-col :span="4">
        <div>
          <data-dec></data-dec>
        </div>
      </el-col>
      <el-col :span="6">
        <!-- <router-link to="/plan/resultTravel">
          <el-button type="">返回标准模式</el-button>
        </router-link> -->
        <div>
          
          <day-travel-detail></day-travel-detail>
        </div>

      </el-col>
      <el-col :span="14">
        <!-- {{old_showDay}} -->
        <!-- <p>{{storeShowDay}}</p> -->
        <div>
          <!-- {{storeShowDayDetail}} -->
        </div>
        <el-button style="float:left;" type="" @click="refresh">刷新</el-button>
        <div id="showMap">

        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import DayTravelDetail from './DayTravelDetail'
import DataDec from './DataDec'
import store from '@/components/store/store.js'
import axios from 'axios'
axios.defaults.withCredentials = true
export default {
  data() {
    return {
      msg: 'Hello, MAp!',
      pointList: '',
      old_showDay: '',
      showDay: ''

    }
  },
  computed: {
    // 获取store showDay
    // storeShowDay() {
    //   if(this.old_showDay !== this.$store.state.showDay){
    //     $store.commit('storeShowDay', this.$store.state.showDay);
    //     this.reload()
    //   }
    // },
    // isReflash(){
    //   let new_showDay = 
    // },
    // 获取展示当天的数据
    storeShowDayDetail() {
      let showDay = this.$store.state.showDay
      let storePlanRes = this.$store.state.testPlanRes['day'][showDay]
      let pointListData = storePlanRes['detail']
      let getPointList = []
      for (let i in pointListData) {
        // console.log(pointListData[i]['start'])
        getPointList.push(pointListData[i]['start'])
      }
      return getPointList
    }
  },
  components: {
    'day-travel-detail': DayTravelDetail,
    'data-dec': DataDec
  },
  methods: {
    // 获取old_showday
    getOldShowDay(){
      this.old_showDay = this.$store.state.showDay
    },
    // 刷新
    refresh() {
      this.reload()
    },
    // 获取坐标点列表
    getPointList() {
      let showDay = this.$store.state.showDay
      let storePlanRes = this.$store.state.testPlanRes['day'][showDay]
      let pointListData = storePlanRes['detail']
      let getPointList = []
      for (let i in pointListData) {
        // console.log(pointListData[i]['start'])
        getPointList.push(pointListData[i]['start'])
      }
      return getPointList
    },
    // trans2Point(lst){

    // },
    // 画图
    paintMap() {
      // 从store获取某天的的坐标点列表
      let pointList = this.getPointList()

      var map = new BMap.Map('showMap') // 创建Map实例
      map.centerAndZoom('厦门', 12)
      //添加地图类型控件
      // var pointA = new BMap.Point(118.073588, 24.451005) // 创建点坐标A--大渡口区
      // var pointB = new BMap.Point(118.111907, 24.442647) // 创建点坐标B--江北区
      // var pointC = new BMap.Point(118.11963, 24.441946) // 创建点坐标B--江北区
      // var pointD = new BMap.Point(118.1322311838, 24.4323874274) // 创建点坐标B--江北区
      let points = []
      for (let n in pointList) {
        console.log(n)
        // console.log(pointList[n][0])
        // console.log(pointList[n][1])
        // 分割字符串
        let toList = pointList[n].split(',')
        console.log(toList)
        // 字符串转换成float
        let l1 = parseFloat(toList[0])
        let l2 = parseFloat(toList[1])
        let pointName = 'point' + n
        console.log(pointName)
        var pointName = new BMap.Point(l1, l2)
        points.push(pointName)
      }

      console.log(points)
      // alert(point1)

      let markers = []
      for (let m in points) {
        let markerName = 'marker' + m
        var markerName = new BMap.Marker(points[m])
        var opts = {
          position: points[m], // 指定文本标注所在的地理位置
          offset: new BMap.Size(20, 0) //设置文本偏移量
        }
        markerName.setLabel(new BMap.Label(m, opts))
        map.addOverlay(markerName)
        markers.push(markerName)
      }
      console.log(markers)

      // var marker2 = new BMap.Marker(pointA)
      // var marker1 = new BMap.Marker(pointB)
      // var marker3 = new BMap.Marker(pointC)
      // var marker4 = new BMap.Marker(pointD)
      // var opts = {
      //   position: pointA, // 指定文本标注所在的地理位置
      //   offset: new BMap.Size(20, 0) //设置文本偏移量
      // }
      // marker2.setLabel(new BMap.Label('1', opts))

      
      // map.addOverlay(marker2)
      // map.addOverlay(marker1)
      // map.addOverlay(marker3)
      // map.addOverlay(marker4)
      var polyline = new BMap.Polyline(points, {
        strokeColor: 'red',
        strokeWeight: 3,
        strokeOpacity: 1
      }) //定义折线
      polyline.setStrokeStyle('dashed')
      map.addOverlay(polyline) //添加折线到地图上
      map.addControl(
        new BMap.MapTypeControl({
          mapTypes: [BMAP_NORMAL_MAP, BMAP_HYBRID_MAP]
        })
      )
      map.setCurrentCity('厦门') // 设置地图显示的城市 此项是必须设置的
      map.enableScrollWheelZoom(true)
    }
  },
  mounted() {
    this.paintMap()
    this.getOldShowDay()
  },
  inject: ['reload'],
  store
}
</script>

<style scoped>
#baiduMap {
  min-height: 620px;
}
#showMap {
  min-height: 620px;
}
</style>
