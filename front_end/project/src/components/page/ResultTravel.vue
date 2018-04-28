<template>
  <div id="resultTravel">
    <!-- <h1>{{msg}}</h1> -->
    <el-row :gutter="20" id="resTitle" class="resTitle">
      规划结果页
      <el-button-group>
        <el-button class="test" icon="el-icon-tickets">标准模式</el-button>
        <router-link to="/plan/map">
          <el-button class="test" icon="el-icon-location-outline">地图模式</el-button>
        </router-link>

      </el-button-group>

    </el-row>
    <el-row :gutter="20">
      <!-- 日期块 -->
      <el-col :span="6">
        <data-dec></data-dec>
      </el-col>

      <!-- 该日行程块 -->
      <el-col :span="9">
        <day-travel-detail></day-travel-detail>
      </el-col>
      <!-- 景点推荐块 -->
      <el-col :span="9">
        <recommend-options></recommend-options>
      </el-col>
    </el-row>

  </div>
</template>

<script>
// import axios from 'axios'
import DataDec from './DataDec'
import DayTravelDetail from './DayTravelDetail'
import RecommendOptions from './RecommendOptions'
export default {
  data() {
    return {
      msg: 'Hello, World!',
      heatMapData: []
    }
  },
  created() {},
  components: {
    'data-dec': DataDec,
    'day-travel-detail': DayTravelDetail,
    'recommend-options': RecommendOptions
  }
}
</script>

<style scoped>
#resultTravel {
  padding-top: 20px;
  min-height: 500px;
  background-color: #f2f1ed;
}

#resTitle {
  text-align: left;
  height: 50px;
  font-size: 24px;
  /* background-color: darksalmon; */
  padding-left: 20px;
  /* padding: 0px; */
  /* margin-top: 0; */
}

.resTest1 {
  background-color: #293e47;
  height: 50px;
}
.resTest2 {
  background-color: #838383;
  height: 50px;
}

.dateList {
  height: 100px;
  width: 100%;
  /* color: #fff; */
  background-color: #ffffff;
  /* padding: 10px; */
  /* margin:  */
}

.test {
  /* background-color: #14233A; */
  /* color: #ffffff; */
}
</style>
