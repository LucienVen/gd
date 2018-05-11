<template>
  <div id="resultTravel" v-loading="" element-loading-text="拼命加载中">
    
    <!-- <h1>{{msg}}</h1> -->
    <el-row :gutter="20" id="resTitle" class="resTitle">
      规划结果页
      <el-button-group>
        <el-button class="test" icon="el-icon-tickets">标准模式</el-button>
        <router-link to="/plan/map">
          <el-button class="test" icon="el-icon-location-outline">地图模式</el-button>
        </router-link>

        <el-button type="" style="" @click="savePlan">保存规划</el-button>
        <el-button type="" style="float:right;margin-right:10px;" @click="refresh">刷新</el-button>
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
    <div>
      <!-- {{storeTestPlanRes}} -->
    </div>
  </div>
</template>

<script>
// import axios from 'axios'
import store from '@/components/store/store.js'
import DataDec from './DataDec'
import DayTravelDetail from './DayTravelDetail'
import RecommendOptions from './RecommendOptions'
import axios from 'axios'
axios.defaults.withCredentials = true
export default {
  data() {
    return {
      msg: 'Hello, World!',
      heatMapData: [],
      loading: true,
      test: ''

    }
  },
  computed: {
    storeTestPlanRes() {
      // this.$store.state.selectType
      this.test = this.$store.state.testPlanRes
    },
    storePlanLoading(){
      // alert(this.$store.state.planLoading)
      return this.$store.state.planLoading
    }
  },
  watch:{
    test: function(newloading, oldloading){
      this.loading = false
    }
  },
  methods: {
    // 发起路线规划请求
    design() {
      let start_city = this.$store.state.beginCity[1].substr(0, 2)
      let type_id = this.$store.state.selectType.join(',')
      let go_off = this.$store.state.schedule.join(',')
      let arrvail = this.$store.state.schedule[0]
      let play_time = this.$store.state.travelComfort

      let name = this.$store.state.selectCityVal
      let transDict = this.$store.state.transDict
      let end_city = ''
      transDict.forEach((item, index) => {
        if (item.name == name) {
          end_city = item.transName
        }
      })

      // console.log(start_city)
      // console.log(end_city)
      // console.log(type_id)
      // console.log(get_off)
      // console.log(arrvail)
      // console.log(play_time)

      let that = this
      axios({
        method: 'post',
        url: 'http://localhost:8089/gd/back_end/public/index.php/v1/design',
        data: {
          type_id: type_id,
          // type_id: '1,2,5,6,7,8,9,10,11,12',
          go_off: go_off,
          // go_off: '2018-06-01,2018-06-03',
          // arrival: '2018-06-01 18:00',
          arrival: go_off[0],
          play_time: 0,
          start_city: start_city,
          end_city: end_city
        },
        withCredentials: true
      }).then(function(response) {
        that.$store.commit('storeTestPlanRes', response.data.data)
        // alert('核心功能！！！！！')
        // that.loading = false
        that.$message({
          showClose: true,
          center: true,
          message: '路线规划成功！',
          type: 'success'
        })
        
        // console.log(response.data)
      })
    },
    // 刷新
    refresh() {
      this.reload()
    },
    savePlan() {
      let data = this.$store.state.testPlanRes
      // alert(data.data['id'])

      // console.log(data)
      let that = this
      axios({
        method: 'post',
        url: 'http://localhost:8089/gd/back_end/public/index.php/v1/plan',
        data: data,
        withCredentials: true
      }).then(function(response) {
        alert('ojbk22222!')
      })
    }
  },
  mounted() {
    this.loading = true
    // 发起路线规划请求
    // this.design()
  },
  created() {},
  components: {
    'data-dec': DataDec,
    'day-travel-detail': DayTravelDetail,
    'recommend-options': RecommendOptions
  },
  inject: ['reload'],

  store
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
