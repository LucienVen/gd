<template>
  <div id="dataDec">
    <!-- <p>{{storeSchedule}}</p> -->
    <!-- <p>{{dayNum}}</p>
    <p>{{storeDay}}</p> -->
    <!-- <p>{{storePlanRes}}</p> -->
    <!-- <hr /> -->

    <!-- <el-col :span="5"> -->
    <!-- $store.commit('storeShowDay', travelMode) -->
    <div v-for="(item, index) in storePlanRes">
      <el-card :body-style="{ padding: '0px'}" shadow="hover" @click.native="$store.commit('storeShowDay', index);$store.commit('storeMoveCity', item.move_city);$store.commit('storeShowTime', computDate(index));">
        <div class="list">
          <!-- 图标 -->
          <div class="iconDay">
            D{{index+1}}
          </div>
          <!-- 显示过程与日期 -->
          <div class="dataSim">
            <p>{{computDate(index)}}</p>
            <!-- storeSchedule -->
            <!-- <p>{{storeSchedule[0]}}</p> -->
            <p>{{item.move_city}}</p>
            <!-- <p v-if="item.from_city != null">{{item.from_city}} => {{item.to_city}}</p> -->
            <!-- <p v-else>{{item.to_city}}</p> -->
          </div>
        </div>
      </el-card>
    </div>

    <!-- <p>
          {{storeDataList}}
        </p> -->
    <!-- </el-col> -->
  </div>
</template>

<script>
import store from '@/components/store/store.js'
export default {
  data() {
    return {
      isShow: true,
      dayNum: ''
    }
  },
  mounted() {
    // this.storeSchedule()
    this.getDayNum()
    // this.storeTestTravelDate()
  },
  computed: {
    // schedule
    // storeSchedule() {
    //   return this.$store.state.schedule
    // },
    // 从store中获取日期出行列表
    // storeTestTravelDate() {
    //   return this.$store.state.testTravelDate
    // },
    // store
    // 需要显示的某日行程
    storeShowDay() {
      return this.$store.state.showDay
    },
    // test 日程数据
    storePlanRes() {
      return this.$store.state.testPlanRes['day']
    },
    storeDay() {
      return this.$store.state.testPlanRes['go_off']
    }
  },
  methods: {
    // 计算日期
    computDate(index) {
      let day = this.storeDay
      // let res = day + ' / ' + index
      var dd = new Date(day)
      dd.setDate(dd.getDate() + index)
      let year = dd.getFullYear()
      let month = dd.getMonth()+1
      let  nowday = dd.getDate()
      let res = year+'年'+month+'月'+nowday+ '日'
      return res
    },
    test(index) {
      alert('index:' + index)
    },
    getDayNum() {
      let dd = this.$store.state.testPlanRes['day'].length
      // alert(dd)
      console.log(dd)
      //
      // return dd
      this.dayNum = dd
    }
  },
  store
}
</script>

<style scoped>
#dataDec {
  /* width: 100%; */
  background-color: #fff;
  height: 400px;
  overflow: auto;
}

#dataDec::-webkit-scrollbar {
  /* 整个滚动条 */
  width: 4px;
  background: #f2f1ed;
  border-radius: 6px;
}
#dataDec::-webkit-scrollbar-thumb {
  /* 滚动条 */
  background: #c2c2c2;
  border-radius: 6px;
}

.list {
  height: 100px;
  background-color: dimgray;
  margin: 10px;
  overflow: hidden;
}

.iconDay {
  background-color: rgb(87, 105, 131);
  float: left;
  width: 60px;
  height: 60px;
  border-radius: 50%;
  margin-top: 17px;
  margin-left: 17px;
  line-height: 60px;
  color: #ffffff;
  font-size: 24px;
}
.dataSim {
  background-color: rgb(213, 218, 213);
  height: 100%;
  padding-top: 30px;

  text-align: left;
}

.dataSim p {
  margin: 0%;
  padding-left: 30%;
  /* margin-left: 30px; */
}
</style>
