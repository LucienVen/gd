<template>
  <div id="dayTravelDetail">

    <el-card :body-style="{ padding: '0px' }" shadow="hover">
      <div slot="header" class="aDay">
        <!-- <p>{{diaTitle}}</p> -->
        <div class="aDayTime">5月2日</div>
        <!-- <div>地点</div> -->
        <div>厦门</div>
        <div style="width:50%; font-size:10px; color:#9f9f9f;">
          规划行程时间: 适中
          <el-progress :percentage="50" color="#7DC28F"></el-progress>
        </div>
        <!-- <div>{{storeDiaTitle}}</div> -->
        <!-- <el-button :plain="true" @click="open5">消息</el-button>
        <el-button :plain="true" @click="open6">close</el-button>
        <el-button :plain="true" @click="closeNotice">close notice</el-button> -->
      </div>
      <div v-for="(i, index) in test" class="dayItem">
        <a href="javascript:void(0);" class="itemTitle" :class="{mouseOut:isMouseOut[0],mouseOver:isMouseOver[0]}" @mouseover="overOrOutShow(index)" @mouseout="overOrOutShow(index)" :key="i.name" @click="isShow();$store.commit('storeSelectDiaTitle', i.name)">
          <i class="el-icon-star-off"></i>
          {{i.name}}
          <!-- {{isMouseOut[index]}}     -->
        </a>
        <div class="itemTraffic">
          123
        </div>
      </div>

    </el-card>

    <!-- <view-point-dia></view-point-dia> -->

    <el-dialog :title="storeDiaTitle" :visible.sync="dialogVisible" width="50%" style="text-align:left;">
      <!-- <span>{{storeDiaTitle}}</span> -->
      <!-- <div>{{scenicData}}</div> -->
      <hr style="margin-top:-20px;">
      <div v-for="item in scenicData">
        <!-- <p>{{item.name}}</p> -->
        <!-- <p>{{item.detail}}</p> -->
        <el-row :gutter="30" class="diaRow">
          <el-col :span="14">
            <div class="diaBackground">
              <img :src="item.photo_url" alt="">
            </div>
          </el-col>
          <el-col :span="10">
            <div>
              景点类型：
              <span>{{item.type}}</span>
            </div>
            <div v-if="item.level != null">
              景点星级：
              <span>{{item.level}}</span>
            </div>
            <div>
              建议游玩时长：
              <span>{{item.play_time}}</span>
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
                {{item.detail}}
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
                {{item.location}}
              </div>
              <div class="cardButtonLine" v-if="item.open_time != null">
                <span>
                  <i class="el-icon-time"></i>
                  开放时间：</span>
                {{item.open_time}}
              </div>
              <div class="cardButtonLine" v-if="item.ticket_msg != null">
                <span>
                  <i class="el-icon-tickets"></i>
                  票务信息：</span>
                {{item.ticket_msg}}
              </div>
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
import ViewPointDialog from './ViewPointDialog'
export default {
  data() {
    return {
      // 鼠标事件
      isMouseOver: [],
      isMouseOut: [],
      //is: [],

      diaTitle: '',
      msg: 'Hello, World!',
      dialogVisible: false,

      // notice框状态
      noticeShow: false,
      noticeMsg: 'Hello, world!',

      test: [
        { name: '鼓浪屿' },
        { name: '厦门大学' },
        { name: '芙蓉隧道' },
        { name: '曾厝垵' }
      ]
    }
  },
  computed: {
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
      return null
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
    }
  },

  methods: {
    overOrOutShow(index) {
      this.isMouseOver[index] = !this.isMouseOver[index]
      this.isMouseOut[index] = !this.isMouseOut[index]
    },
    // overShow(){
    //   this.isMouseOver = !this.isMouseOver
    //   this.isMouseOut = !this.isMouseOut
    // },
    isShow() {
      console.log('isshow...')
      return (this.dialogVisible = true)
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
  components: {
    'view-point-dia': ViewPointDialog
  },
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

