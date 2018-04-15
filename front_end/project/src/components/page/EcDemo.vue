<template>
    <div id="ec">
        <!--创建一个echarts的容器-->
        <div id="echartContainer" style="width:100%; height:500px"></div>
    </div>
</template>

<script>
// var echarts = require('vue-echarts')
// import echarts from 'vue-echarts/components/ECharts.vue';
// import ECharts from 'vue-echarts/components/ECharts.vue';
// Vue.component('echarts', ECharts);

import echarts from 'echarts'
export default {
  mounted() {
    //基于准备好的dom, 初始化echarts实例
    let myChart = echarts.init(document.getElementById('echartContainer'))
    myChart.setOption({
      xAxis: {
        data: ['衬衫', '羊毛衫', '雪纺衫', '裤子', '高跟鞋', '袜子'],
        name: '产品'
      },
      yAxis: {},
      series: [
        {
          name: '销量',
          type: 'line',
          data: [10, 20, 36, 10, 10, 20],
          itemStyle: {
            normal: {
              color: 'hotpink'
            }
          }
        }
      ],
      //   title组件
      title: {
        show: true, //显示折线图
        text: '简单折线图', //标题文字
        link: 'http://echarts.baidu.com/option.html#title.link', //主标题超文本链接,
        subtext: '熟悉title的配置项', //副标题
        left: 50, //配置title的位置
        padding: [5, 20, 5, 10] //title的padding值
      },
      //   工具箱组件
      toolbox: {
        show: true, //是否显示工具栏组件
        orient: 'vertical', //工具栏icon的布局朝向
        itemSize: 18, //工具栏icon的大小
        itemGap: 20, //item之间的间距
        right: 20, //toolbox的定位位置
        feature: {
          saveAsImage: { show: true }, //导出图片
          dataView: { show: true }, //数据视图
          magicType: {
            //动态类型切换
            type: ['line', 'bar']
          },
          dataZoom: { show: true }, //数据区域缩放
          restore: { show: true } //重置
        }
      },
      //   提示框组件
      tooltip: {
        trigger: 'axis' //通过哪种方式触发tip
      },
      //   标注点(worry)
      markPoint: {
        data: [{ type: 'max', name: '最大值' }, { type: 'min', name: '最小值' }]
      },
      //   标注线(worry)
      markLine: {
        data: [
          { type: 'average', name: '平均值' },
          { type: 'max', name: '最大值' },
          { type: 'min', name: '最小值' }
        ]
      }
    })
  }
}
</script>

<style scoped>
#ec{
   
}
</style>
