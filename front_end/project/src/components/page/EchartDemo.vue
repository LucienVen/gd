<template>
  <!--为echarts准备一个具备大小的容器dom-->
  <!-- <div id="main" style="width: 100%;height: 500px;"></div> -->
  <div class="charts">
    <div id="myChart" style="width:100%;height: 500px;"></div>
  </div>
</template>
<script>
import echarts from 'echarts'
import { data_point } from '../store/points.js'
// require('../../assets/js/china')
// require('../../assets/js/bmap.min.js')
// import '../../assets/js/china'
// import '../../assets/js/bmap.min.js'
// 使用store
// import homeStore from '@/components/store/homeStore'
export default {
  mounted(options) {
    // let echarts = require('echarts/lib/echarts') // 引入基本模板，如果在项目中对体积要求比较苛刻，也可以只按需引入需要的模块(可以按需引入的模块列表见见本博客底部)
    // require("./lib/chart/map");

    // 例如：引入柱状图
    //require('echarts/lib/chart/bar');
    let chartBox = document.getElementsByClassName('charts')[0]
    let myChart = document.getElementById('myChart')

    function resizeCharts() {
      //为调整图标尺寸的方法
      myChart.style.width = chartBox.style.width + 'px'
      myChart.style.height = chartBox.style.height + 'px'
    }
    let mainChart = echarts.init(myChart) // 基于准备好的dom，初始化echarts实例
    //显示加载动画
    mainChart.showLoading()

    var option = null
    // 存储数据
    var data = []
    var geoCoordMap = {}

    // console.log(typeof(data_point));
    data_point.forEach((item, index) => {
      let temp_data = { name: item.name, value: item.sale_count / 100 }
      let geo_temp = item.data_point.split(',')
      geoCoordMap[item.name] = geo_temp
      data.push(temp_data)
    })

    var convertData = function(data) {
      var res = []
      for (var i = 0; i < data.length; i++) {
        var geoCoord = geoCoordMap[data[i].name]
        if (geoCoord) {
          res.push({
            name: data[i].name,
            value: geoCoord.concat(data[i].value)
          })
        }
      }
      return res
    }

    // 指定图表的配置项和数据
    option = {
      backgroundColor: '#404a59',
      title: {
        text: '去哪儿2月景点热度分布图',
        subtext: 'data from qunar',
        sublink:
          'http://piao.qunar.com/ticket/list.htm?keyword=%E4%B8%AD%E5%9B%BD&region=&from=mps_search_suggest&sort=pp&page=1',
        left: 'center',
        textStyle: {
          color: '#fff'
        }
      },
      tooltip: {
        trigger: 'item'
      },
      legend: {
        orient: 'vertical',
        y: 'bottom',
        x: 'right',
        data: ['qunar viewpoint count'],
        textStyle: {
          color: '#fff'
        }
      },

      geo: {
        map: 'china',
        label: {
          emphasis: {
            show: false
          }
        },
        roam: true,
        itemStyle: {
          normal: {
            areaColor: '#323c48',
            borderColor: '#111'
          },
          emphasis: {
            areaColor: '#2a333d'
          }
        }
      },
      series: [
        {
          name: 'qunar viewpoint count',
          type: 'scatter',
          coordinateSystem: 'geo',
          data: convertData(data),
          symbolSize: function(val) {
            return val[2] / 10
          },
          label: {
            normal: {
              formatter: '{b}',
              position: 'right',
              show: false
            },
            emphasis: {
              show: true
            }
          },
          itemStyle: {
            normal: {
              color: '#ddb926'
            }
          }
        },
        {
          name: 'Top 5',
          type: 'effectScatter',
          coordinateSystem: 'geo',
          data: convertData(
            data
              .sort(function(a, b) {
                return b.value - a.value
              })
              .slice(0, 6)
          ),
          symbolSize: function(val) {
            return val[2] / 10
          },
          showEffectOn: 'render',
          rippleEffect: {
            brushType: 'stroke'
          },
          hoverAnimation: true,
          label: {
            normal: {
              formatter: '{b}',
              position: 'right',
              show: true
            }
          },
          itemStyle: {
            normal: {
              color: '#f4e925',
              shadowBlur: 10,
              shadowColor: '#333'
            }
          },
          zlevel: 1
        }
      ]
    }

    // 使用刚指定的配置项和数据显示图表。
    if (option && typeof option === 'object') {
      mainChart.setOption(option, true)
      //   隐藏加载动画
      mainChart.hideLoading()
    }
  }
}
</script>
<style scoped>
/* * {
  margin: 0;
  padding: 0;
  list-style: none;
} */
</style>