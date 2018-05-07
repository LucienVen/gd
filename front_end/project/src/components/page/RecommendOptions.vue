<template>
    <div id="recommendOptions">
        <el-card :body-style="{ padding: '0px'}" shadow="hover">
            <!-- <div class="dateList"> -->
            <div slot="header" class="">
                <div style="text-align:left;font-size:17px;font-weight:bold;">{{msg}}</div>
                <!-- {{storeScenicRecommond}} -->
            </div>
            <el-tabs v-model="activeName" @tab-click="handleClick">
                <el-tab-pane label="景点推荐" name="first">
                    <el-row :gutter="30" v-for="(item, index) in storeScenicRecommond" style="margin: 20px 10px;">
                        <el-col :span="24">
                            <el-card :body-style="{ padding: '0px' }" shadow="hover" class="cardRecommond" @click.native="clickCard()">
                                <el-row>
                                    <el-col :span="12">
                                        <img :src="item.photo_url" alt="" style="width:230px;">
                                    </el-col>
                                    <el-col :span="12" style="color:#636363" class="cardViewDetail">
                                        <div class="cardViewTitle">{{item.name}}</div>
                                        <div class="cardViewShowSmall">{{item.location}}</div>
                                        <div>
                                            <el-rate v-model="item.score" disabled text-color="#ff9900" score-template="item.score">
                                            </el-rate>
                                        </div>
                                        <div class="cardViewShowSmall">{{item.play_time}}</div>
                                        <span v-for="tap in item.tap" style="float:right;">
                                            <el-tag style="margin-left: 5px;" type="info" size="mini">{{tap}}</el-tag>
                                        </span>
                                    </el-col>
                                </el-row>
                            </el-card>

                        </el-col>

                    </el-row>
                </el-tab-pane>
                <el-tab-pane label="酒店信息" name="second">
                    llllll
                </el-tab-pane>
                <el-tab-pane label="天气信息" name="third">
                    sadasdsa
                </el-tab-pane>

            </el-tabs>
        </el-card>
    </div>
</template>

<script>
import store from '@/components/store/store.js'
export default {
  data() {
    return {
      msg: '厦 门',
      activeName: 'first'
    }
  },
  computed: {
    storeScenicRecommond() {
      return this.$store.state.scenicRecommond
    }
  },
  methods: {
    clickCard() {
      alert('Hello, World!')
    }
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
  color: #7D7D7D;
  font-size: 10px;
}
</style>
