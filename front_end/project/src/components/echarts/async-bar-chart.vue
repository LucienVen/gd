<template>
    <div>
        <div id="barContainer" style="width:100%; height:500px"></div>
        <!--创建一个echarts的容器-->
    </div>
</template>

<script>
import echarts from 'echarts'
//从aysnc-barChart-option.js中引入option
import { option } from '../echarts/aysnc-barChart-option'
import axios from 'axios'

export default {
  methods: {
    drawBarChart() {
      //     let myChart = echarts.init(document.getElementById('pieContainer'))
      // myChart.setOption(option)
      // 基于准备好的dom，初始化echarts实例
      var myChart = echarts.init(document.getElementById('barContainer'))
      // 绘制基本图表
      myChart.setOption(option)
      //显示加载动画
      myChart.showLoading()
      // 使用Axios的get 方式来获得数据

      axios
        .get('static/asyncBarChart.json')
        .then(response => {
          console.log(response.data)
          //   隐藏加载动画
          myChart.hideLoading()
          myChart.setOption({
            series: [
              {
                data: response.data.product //将异步请求获取到的数据进行装载
              }
            ]
          })
        })
        .catch(error => {
          console.log(error)
          alert('42')
        })
    }
  },
  mounted() {
    //调用drawBarChart()
    this.drawBarChart()
  }
}
</script>