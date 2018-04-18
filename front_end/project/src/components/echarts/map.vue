<template>
  <div>
    <div id="mapContainer" style="width:100%; height:600px"></div>

  </div>
</template>

<script>
import echarts from 'echarts'
import { option } from '../echarts/map-option'

import '../../../static/js/china'
import axios from 'axios'
export default {
  name: '',
  data() {
    return {}
  },
  created() {},

  methods: {
    drawChinaMap() {
      var myChart = echarts.init(
        document.getElementById('mapContainer'),
        'dark'
      )

      // option.data = heatMapData
      // console.log(option.data)
      myChart.showLoading()

      myChart.setOption(option)
      axios
        .get(
          'http://localhost:8089/gd/back_end/public/index.php/v1/destination/heatmap'
        )
        .then(response => {
          myChart.hideLoading()
          // console.log(response.data)
          myChart.setOption({
            series: [
              {
                data: response.data.data //将异步请求获取到的数据进行装载
              }
            ]
          })

          // this.heatMapData = response.data
        })
        .catch(error => {
          console.log('asdasdsdasdasds')
          console.log(error)
        })
    }
  },
  mounted() {
    this.drawChinaMap()
  }
}
</script>