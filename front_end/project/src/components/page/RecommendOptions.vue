<template>
  <div id="recommendOptions">
    <el-card :body-style="{ padding: '0px'}" shadow="hover">
      <!-- <div class="dateList"> -->
      <div slot="header" class="">
        <div style="text-align:left;font-size:17px;font-weight:bold;">{{msg}}</div>
        <!-- {{storeScenicRecommond}} -->
        <!-- {{testRecommondViewpoint}} -->
      </div>
      <el-tabs v-model="activeName" @tab-click="handleClick">
        <el-tab-pane label="景点推荐" name="first">
          <el-row :gutter="30" v-for="(item, index) in testRecommondViewpoint" style="margin: 20px 10px;">
            <el-col :span="24">
              <el-card :body-style="{ padding: '0px' }" shadow="hover" class="cardRecommond" @click.native="clickCard(item.id)">
                <el-row>
                  <el-col :span="12">
                    <img :src="item.cover_url" alt="" style="width:230px;">
                  </el-col>
                  <el-col :span="12" style="color:#636363" class="cardViewDetail">
                    <div class="cardViewTitle">{{item.name}}</div>
                    <div class="cardViewShowSmall">{{item.location}}</div>
                    <div>
                      <el-rate v-model="item.score" disabled text-color="#ff9900" score-template="item.score">
                      </el-rate>
                    </div>
                    <div class="cardViewShowSmall">{{item.play_time}}</div>
                    <span v-for="tap in item.impression" style="float:right;">
                      <el-tag style="margin-left: 5px;" type="info" size="mini">{{tap}}</el-tag>
                    </span>
                  </el-col>
                </el-row>
              </el-card>

            </el-col>

          </el-row>
        </el-tab-pane>
        <el-tab-pane label="酒店信息" name="second">
          <!-- 推荐酒店 -->

          <el-row :gutter="30" v-for="(item, index) in testRecommondHotel" style="margin: 20px 10px;">
            <el-col :span="24">
              <el-card :body-style="{ padding: '0px' }" shadow="hover" class="cardRecommond" @click.native="clickCard(item.id)">
                <el-row>
                  <el-col :span="12">
                    <img :src="item.small_photo_link" alt="" style="width:230px;">
                  </el-col>
                  <el-col :span="12" style="color:#636363" class="cardViewDetail">
                    <div class="cardViewTitle">{{item.hotel_name}}</div>
                    <div class="cardViewShowSmall">{{item.address}}</div>
                    <div>
                      <el-rate v-model="item.score" disabled text-color="#ff9900" score-template="item.score">
                      </el-rate>
                    </div>
                    <!-- 离你的距离 -->
                    <div class="cardViewShowSmall">距离：{{item.distance_from_you.toFixed(2)}}KM</div>
                    <div>
                      <span v-for="tap in item.impression" v-if="item.impression != ''">
                        <el-tag style="margin-left: 5px;" type="info" size="mini">{{tap}}</el-tag>
                      </span>
                    </div>

                  </el-col>
                </el-row>
              </el-card>

            </el-col>

          </el-row>
        </el-tab-pane>
        <!-- <el-tab-pane label="天气信息" name="third">
            //TODO
          </el-tab-pane> -->

      </el-tabs>
    </el-card>

    <!-- 模态框 -->
    <!-- <el-dialog :title="storeDiaTitle" :visible.sync="dialogVisible" width="50%" style="text-align:left;">
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
              <span>
                <b>{{viewPointData.type_name}}</b>
              </span>
            </div>
            <div v-if="viewPointData.level != null" style="margin-top:5px">

              景点星级：
              <el-rate v-model="level2num" disabled text-color="#ff9900">
              </el-rate>
              <span v-show="false">{{rate(viewPointData.level)}}</span>
            </div>
            <div style="margin-top:5px">
              建议游玩时长：
              <span>
                <b>{{viewPointData.cost_time}}</b> 小时</span>
            </div>
            <div style="margin-top:10px">
              印象标签：
              <div>
                <el-tag v-for="m in viewPointData.impression" type="info" style="margin:2px;">
                  <b>{{m}}</b>
                </el-tag>
              </div>
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
            </el-card>
          </el-col>
        </el-row>

      </div>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogVisible = false">取 消</el-button>
        <el-button type="primary" @click="dialogVisible = false">确 定</el-button>
      </span>
    </el-dialog> -->
  </div>
</template>

<script>
import store from '@/components/store/store.js'
import axios from 'axios'
axios.defaults.withCredentials = true
export default {
  data() {
    return {
      msg: '厦 门',
      activeName: 'first',
      testRecommondViewpoint: '',
      testRecommondHotel: ''
    }
  },
  computed: {
    storeScenicRecommond() {
      return this.$store.state.scenicRecommond
    }
  },
  methods: {
    clickCard(v_id) {
      alert(v_id)
    },
    // 获取推荐景点列表
    getHotViewpoint() {
      var that = this
      axios({
        method: 'get',
        url:
          'http://localhost:8089/gd/back_end/public/index.php/v1/destination?hot=1&city=厦门'
      })
        .then(function(response) {
          // alert('sdadas')
          that.testRecommondViewpoint = response.data.data.data
          // console.log(response.data.data)
        })
        .catch(function(error) {
          // alert('ffffffffffffffffff')
          console.log(error.response)
        })
    },
    // 获取酒店推荐信息
    getHotHotel() {
      var that = this
      axios({
        method: 'get',
        url:
          'http://localhost:8089/gd/back_end/public/index.php/v1/hotel?type=0&position=24.527873,118.114686'
      })
        .then(function(response) {
          // alert('sdadas')
          that.testRecommondHotel = response.data.data.data
          // console.log(response.data.data)
        })
        .catch(function(error) {
          // alert('ffffffffffffffffff')
          console.log(error.response)
        })
    }
  },
  mounted() {
    this.getHotViewpoint()
    this.getHotHotel()
  },
  store
}
</script>

<style scoped>
#recommendOptions {
  height: 600px;
  overflow: auto;
}

#recommendOptions::-webkit-scrollbar {
  /* 整个滚动条 */
  width: 4px;
  background: #f2f1ed;
  border-radius: 6px;
}
#recommendOptions::-webkit-scrollbar-thumb {
  /* 滚动条 */
  background: #c2c2c2;
  border-radius: 6px;
}

.tabPane {
  width: 33%;
}

.cardRecommond div {
  /* padding: 10px; */
}
.cardViewDetail {
  padding: 10px 10px;
}
.cardViewDetail div {
  text-align: right;
  margin-bottom: 10px;
}
.cardViewTitle {
  font-size: 16px;
  font-weight: bold;
}
.cardViewShowSmall {
  color: #7d7d7d;
  font-size: 10px;
}
</style>
