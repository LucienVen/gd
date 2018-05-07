<template>
  <div id="baiduMap">
    <el-row :gutter="20">
      <el-col :span="8">
        <!-- <router-link to="/plan/resultTravel">
          <el-button type="">返回标准模式</el-button>
        </router-link> -->
        <div>
          <day-travel-detail></day-travel-detail>
        </div>

      </el-col>
      <el-col :span="16">
        <div id="showMap">

        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import DayTravelDetail from './DayTravelDetail'

export default {
  components: {
    'day-travel-detail': DayTravelDetail
  },
  mounted() {
    var map = new BMap.Map('showMap') // 创建Map实例
    map.centerAndZoom('厦门', 12)
    //添加地图类型控件
    var pointA = new BMap.Point(118.073588, 24.451005) // 创建点坐标A--大渡口区
    var pointB = new BMap.Point(118.111907, 24.442647) // 创建点坐标B--江北区
    var pointC = new BMap.Point(118.11963, 24.441946) // 创建点坐标B--江北区
    var pointD = new BMap.Point(118.1322311838, 24.4323874274) // 创建点坐标B--江北区
    // 24.4510056516,118.0735888135
    // 24.4445863121,118.1009590515
    // 24.4419466380,118.1196306325
    // 24.4323874274,118.1322311838
    var marker2 = new BMap.Marker(pointA)
    var marker1 = new BMap.Marker(pointB)
    var marker3 = new BMap.Marker(pointC)
    var marker4 = new BMap.Marker(pointD)
    var opts = {
      position: pointA, // 指定文本标注所在的地理位置
      offset: new BMap.Size(20, 0) //设置文本偏移量
    }
    
    marker2.setLabel(new BMap.Label('1', opts))
    
    map.addOverlay(marker2)
    map.addOverlay(marker1)
    map.addOverlay(marker3)
    map.addOverlay(marker4)
    var polyline = new BMap.Polyline([pointA, pointB, pointC, pointD], {
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
