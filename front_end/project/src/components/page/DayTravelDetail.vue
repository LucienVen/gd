<template>
  <div id="dayTravelDetail">

    <el-card :body-style="{ padding: '0px' }" shadow="hover">
      <div slot="header" class="aDay">
        <!-- <p>{{diaTitle}}</p> -->
        <!-- <div>{{storeShowDayDetail}}</div> -->
        <div class="aDayTime">5月2日</div>
        <!-- <div class="aDayTime">{{storeShowDayTime}}</div> -->
        <!-- <div>地点</div> -->

        <div>
          <!-- 厦 门 -->
          {{storeMoveCity}}
          <!-- {{tempPlanData}} -->
          <!-- <el-button size="mini" type="" @click="getViewpointList">test</el-button> -->
        </div>
        <div style="width:50%; font-size:10px; color:#9f9f9f;">
          <!-- 规划行程时间: 适中 -->
          <el-progress :percentage="20" color="#7DC28F"></el-progress>
        </div>
      </div>
      <div v-for="(i, index) in storeShowDayDetail['detail']" class="dayItem">
        <a href="javascript:void(0);" class="itemTitle" :class="{mouseOut:isMouseOut[0],mouseOver:isMouseOver[0]}" @mouseover="overOrOutShow(index)" @mouseout="overOrOutShow(index)" :key="i.name" @click="isShow(i.start_des);$store.commit('storeSelectDiaTitle', i.start_name);">
          <i class="el-icon-star-off"></i>
          {{i.start_name}}
          <!-- {{isMouseOut[index]}}     -->
        </a>
        <div class="itemTraffic">
          {{i.distance}}
        </div>
      </div>

    </el-card>
    <!-- {{axiosDataList}} -->

    <!-- <view-point-dia></view-point-dia> -->

    <!-- 模态框 -->
    <el-dialog :title="storeDiaTitle" :visible.sync="dialogVisible" width="50%" style="text-align:left;">
      <hr style="margin-top:-20px;">
      <div v-model="viewPointData">
        <el-row :gutter="30" class="diaRow">
          <el-col :span="14">
            <div class="diaBackground">
              <img :src="viewPointData.cover_url" alt="">
            </div>
          </el-col>
          <el-col :span="10">
            <div style="margin-top:5px">
              景点类型：
              <span><b>{{viewPointData.type_name}}</b></span>
            </div>
            <div v-if="viewPointData.level != null" style="margin-top:5px">
              
              景点星级：
              <el-rate v-model="level2num" disabled text-color="#ff9900">
              </el-rate>
              <span v-show="false">{{rate(viewPointData.level)}}</span>
            </div>
            <div style="margin-top:5px">
              建议游玩时长：
              <span><b>{{viewPointData.cost_time}}</b> 小时</span>
            </div>
            <div style="margin-top:10px">
              印象标签：
              <div>
                <el-tag v-for="m in viewPointData.impression" type="info" style="margin:2px;"><b>{{m}}</b></el-tag>
              </div>

              <!-- <span>{{viewPointData.impression}}</span> -->
            </div>
          </el-col>
        </el-row>
        <el-row class="diaRow">
          <el-col :span="24" class="detailFloat">
            <el-card>
              <div slot="header" class="clearfix">
                <span>简介</span>
              </div>
              <div>
                {{viewPointData.description}}
              </div>
            </el-card>
          </el-col>
        </el-row>
        <el-row class="diaRow" v-if="viewPointData.tip != None">
          <el-col :span="24" class="detailFloat">
            <el-card>
              <div slot="header" class="clearfix">
                <span>tip: </span>
              </div>
              <div>
                {{viewPointData.tip}}
              </div>
            </el-card>
          </el-col>
        </el-row>
        <el-row class="diaRow">
          <el-col :span="24">
            <el-card>
              <div class="cardButtonLine">
                <span>
                  <i class="el-icon-location"></i>
                  地址：
                </span>
                {{viewPointData.location}}
              </div>
              <div class="cardButtonLine" v-if="viewPointData.open_time != null">
                <span>
                  <i class="el-icon-time"></i>
                  开放时间：</span>
                {{viewPointData.open_time}}
              </div>
              <div class="cardButtonLine" v-if="viewPointData.ticket_msg != null">
                <span>
                  <i class="el-icon-tickets"></i>
                  票务信息：</span>
                {{viewPointData.ticket_msg}}
              </div>
              <!-- <div>
                {{viewPointData}}
              </div> -->
            </el-card>

          </el-col>
        </el-row>

      </div>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogVisible = false">取 消</el-button>
        <el-button type="primary" @click="dialogVisible = false">确 定</el-button>
      </span>
    </el-dialog>

  </div>
</template>

<script>
// 引入store
// import store from '../store/store.js'
import store from '@/components/store/store.js'
import axios from 'axios'
axios.defaults.withCredentials = true
// import ViewPointDialog from './ViewPointDialog'
export default {
  data() {
    return {
      // level
      level2num: '',
      // temp plan data
      tempPlanData: '',
      // 景点详细信息
      viewPointData: '',
      // 鼠标事件
      isMouseOver: [],
      isMouseOut: [],
      //is: [],

      diaTitle: '',
      msg: 'Hello, World!',
      dialogVisible: false,

      // notice框状态
      // noticeShow: false,
      // noticeMsg: 'Hello, world!',
      axiosDataList: '123',
      // BeginShowDayDetail: '',
      test: [
        { name: '鼓浪屿' },
        { name: '厦门大学' },
        { name: '芙蓉隧道' },
        { name: '曾厝垵' }
      ]
    }
  },
  mounted() {
    this.storeShowDay()
    this.storeBeginShowDayDetail()
    // setTimeout(
    //   this.reload(),1000
    // )
    
  },
  computed: {
    
    // storeShowDayCity(){
    //   return this.$store.state.showDayCity
    // },
    storeShowDayDetail() {
      let showDay = this.$store.state.showDay
      let storePlanRes = this.$store.state.testPlanRes['day'][showDay]
      return storePlanRes
    },
    // -------------------------------
    // 获取store diaTitle
    lengthTest() {
      var isMouseOut = new Array()
      var isMouseOver = new Array()
      for (var i = 0; i < test.length; i++) {
        isMouseOut[i] = true
        isMouseOver[i] = false
      }
      this.isMouseOut = isMouseOut
      this.isMouseOver = isMouseOver
      // return null
    },
    getLength() {
      return this.test.length
    },
    storeDiaTitle() {
      console.log('computed....')
      return this.$store.state.diaTitle
    },
    scenicData() {
      return this.$store.state.scenicData
    },
    //   moveCity: '',
    // showDayTime: '',
    storeMoveCity() {
      return this.$store.state.moveCity
    },
    storeShowDayTime() {
      return this.$store.state.showDayTime
    }
  },

  methods: {
    // 返回星级数字
    rate(level){
      return this.level2num = level.length
    },
    // 获取store showDay
    storeShowDay() {
      return this.$store.state.showDay
    },
    storeBeginShowDayDetail() {
      let showDay = this.$store.state.showDay
      let storePlanRes = this.$store.state.testPlanRes['day'][showDay]
      this.tempPlanData = storePlanRes
      // alert('asdasd')
    },

    // dialog 把景点列表信息存进
    getViewPointData(v_id) {
      var that = this
      axios({
        method: 'get',
        url:
          this.GLOBAL.apiurl+'destination/' +
          v_id,

        withCredentials: true
      }).then(function(response) {
        // $store.commit('storeAllViewpointList', response.data.data['data'])
        that.viewPointData = response.data.data
        // alert(response.data.data)
      })
    },
    // 景点列表
    // getViewpointList() {
    //   var that = this
    //   axios({
    //     method: 'get',
    //     url:
    //       this.GLOBAL.apiurl+'destination?hot=1&city=厦门',
    //     withCredentials: true
    //   }).then(function(response) {
    //     $store.commit('storeAllViewpointList', response.data.data['data'])
    //     alert('success!')
    //   })
    // },
    // 查询景点信息

    overOrOutShow(index) {
      this.isMouseOver[index] = !this.isMouseOver[index]
      this.isMouseOut[index] = !this.isMouseOut[index]
    },
    // overShow(){
    //   this.isMouseOver = !this.isMouseOver
    //   this.isMouseOut = !this.isMouseOut
    // },
    isShow(v_id) {
      console.log('isshow...')

      this.dialogVisible = true
      this.getViewPointData(v_id)
    }
    // notice() {
    //   if (this.noticeShow) {
    //     // 调用关闭notice框方法
    //     this.closeNotice()
    //     // 更改notice框状态
    //     this.noticeShow = false
    //     // console.log(this.noticeShow);
    //   } else {
    //     // 创建notice实例
    //     this.notice = this.$notify({
    //       title: 'HTML 片段',
    //       dangerouslyUseHTMLString: true,
    //       message:
    //         '<div style="height:200px;width:150px;"><strong>这是 <i>{{noticeMsg}}</i> 片段</strong></div>',

    //       duration: 0,
    //       offset: 110
    //     })
    //     // 更改notice框状态
    //     this.noticeShow = true
    //     // console.log(this.noticeShow);
    //   }
    // },
    // 这里可以实现点击手动关闭message
    // open5() {
    //   this.msg = this.$message({
    //     showClose: true,
    //     message: '恭喜你，这是一条成功消息',
    //     duration: 0
    //   })
    // },
    // open6() {
    //   this.msg.close()
    // },
    // 关闭notice方法
    // closeNotice() {
    //   this.notice.close()
    // }
  },
  // components: {
  //   'view-point-dia': ViewPointDialog
  // },
  inject: ['reload'],
  store
}
</script>

<style scoped>
#dayTravelDetail {
  /* text-align: left; */
  height: 600px;
  overflow: auto;
}

#dayTravelDetail::-webkit-scrollbar {
  /* 整个滚动条 */
  width: 4px;
  background: #f2f1ed;
  border-radius: 6px;
}
#dayTravelDetail::-webkit-scrollbar-thumb {
  /* 滚动条 */
  background: #c2c2c2;
  border-radius: 6px;
}

.aDay {
  text-align: left;
  /* position: fixed; */
  background-color: #ffffff;
  height: 70px;
  width: 500px;
  padding-bottom: 20px;
}

.aDay div {
  margin-bottom: 10px;
}

.aDayTime {
  color: #9f9f9f;
  font-size: 10px;
}

.dayItem {
  padding: 0;

  text-align: left;
  margin-top: 20px;
  margin-bottom: 20px;
}

.itemTitle {
  color: #7a7a7a;
  text-decoration: none;
  display: block;
  height: 38px;
  padding: 20px;
  padding-left: 30px;

  width: 100%;
}
.itemTraffic {
  font-size: 12px;
  line-height: 30px;
  color: #aeaeae;
  padding-left: 30px;
  background-color: #fbfbfb;
  height: 30px;
}
.itemTitle:hover {
  background-color: #d0d0d0;
}
.mouseOver {
  background-color: #d0d0d0;
}
.mouseOut {
  background-color: #ffffff;
}
.diaBackground {
  /* background-color:#F5F5F5; */
}
.detailFloat {
  text-align: left;
}
.diaRow {
  margin-top: 20px;
}
.cardButtonLine {
  margin-bottom: 20px;
  border-bottom: 0.5px dashed #e5e5e5;
}

.cardButtonLine span {
  font-size: 14px;
  font-weight: bolder;
}
</style>

