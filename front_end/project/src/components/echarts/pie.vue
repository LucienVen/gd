<template>
    <div>
        <div id="pieContainer" style="width:100%;height:500px"></div>
    </div>
</template>


<script>
import echarts from 'echarts'
import { option } from '../echarts/pie-option'
export default {
  name: '',
  data() {
    return {}
  },
  mounted() {
    let myChart = echarts.init(document.getElementById('pieContainer'))
    myChart.setOption(option)
  }
}
</script>
        
<style scoped>

</style>