<template>
  <div>
    <div id="mapContainer" style="width:100%; height:600px"></div>

  </div>
</template>

<script>
import echarts from 'echarts'
// import store from '../store/store.js'
// import store from '@/components/store/store.js'

import { option } from '../echarts/map-option'

import '../../../static/js/china'
// import { mapState } from 'vuex'
import axios from 'axios'
export default {
  name: '',
  data() {
    return {}
  },

  computed: {
    // ...mapState({
    //   storeHeatMap: state => state.heatMapData
    // })
    // storeHeatMap() {
    //   return this.$store.state.heatMapData
    // }
  },

  methods: {
    drawChinaMap() {
      var myChart = echarts.init(
        document.getElementById('mapContainer'),
        'dark'
      )

      // option.data = heatMapData
      // console.log(option.data)
      // myChart.showLoading()

      myChart.setOption(option)
      
      axios
        .get(
          this.GLOBAL.apiurl+'destination/heatmap'
        )
        .then(response => {
          myChart.hideLoading()
          myChart.setOption({
            series: [
              {
                data: response.data.data //将异步请求获取到的数据进行装载
              }
            ]
          })
        })
        .catch(error => {
          console.log('asdasdsdasdasds')
          console.log(error)
        })
    }
  },
  mounted() {
    // 派发vuex action
    // this.$store.dispatch('getHeatMapDate')
    this.drawChinaMap()
  },
  created() {}
}
</script>