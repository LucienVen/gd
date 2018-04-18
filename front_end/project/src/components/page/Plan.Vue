<template>
    <div id="plan">
        <el-row :gutter="20">
            <el-col :span="13" :offset="1">
                <el-collapse v-model="activeName" accordion class="coll">
                    <el-collapse-item title="选择目标城市" name="1">
                        <el-row style="padding-left:40px;" :gutter="20">
                            <el-col :span="24">
                                <span>选择城市: </span>
                                <el-select v-model="selectedCity" filterable placeholder="请选择">
                                    <el-option v-for="item in cityData" :key="item.value" :label="item.label" :value="item.value">
                                    </el-option>
                                </el-select>
                            </el-col>

                        </el-row>
                        <el-row style="padding:30px;" :gutter="20">
                            <el-col :span="8">
                                <el-card :body-style="{padding:'0px'}" shadow="hover">
                                    <img class="img" src="../../assets/city/xiamen.jpeg">
                                    <div style="padding:14px;">
                                        <span>厦门</span>
                                    </div>
                                </el-card>

                            </el-col>
                            <el-col :span="8">
                                <el-card :body-style="{ padding: '0px' }" shadow="hover">
                                    <img class="img" src="../../assets/city/guangzhou.jpg">
                                    <div style="padding:14px;">
                                        <span>广州</span>
                                    </div>
                                </el-card>
                            </el-col>
                            <el-col :span="8">
                                <el-card :body-style="{ padding: '0px' }" shadow="hover">
                                    <img class="img" src="../../assets/city/guangzhou.jpg">
                                    <div style="padding:14px;">
                                        <span>成都</span>
                                    </div>
                                </el-card>
                            </el-col>
                        </el-row>
                        <div>
                            <el-button @click="nextStep();$store.commit('storeSelectedCity', selectedCity);">下一步</el-button>
                        </div>

                    </el-collapse-item>
                    <el-collapse-item title="选择意愿游玩景点类型（可不选）" name="2">
                        <p>推荐选项：</p>
                        <el-checkbox-group v-model="pointTypeList" size="small">
                            <!-- <span>推荐选项：</span> -->
                            <el-checkbox v-for="item in recPointType" :label="item.id" :key="item.id" border>{{item.type}}</el-checkbox>
                            <!-- <el-checkbox v-for="ite in commonPointType" :label="ite.id" :key="ite.id" border>{{ite.type}}</el-checkbox> -->
                        </el-checkbox-group>
                        <p>景点类型：</p>
                        <el-checkbox-group v-model="pointTypeList" size="small">
                            <el-checkbox v-for="ite in pointType" :label="ite.id" :key="ite.id" border>{{ite.type}}</el-checkbox>
                        </el-checkbox-group>
                        <p></p>
                        <div>
                            <el-button @click="nextStep();$store.commit('storeSelectType',pointTypeList)">下一步</el-button>
                        </div>
                    </el-collapse-item>
                    <el-collapse-item title="游玩选项" name="3">

                        <div class="block">
                            <span class="demonstration">行程选择：</span>
                            <el-date-picker v-model="schedule" type="daterange" range-separator="至" start-placeholder="开始日期" end-placeholder="结束日期" value-format="yyyy-MM-dd" @change="$store.commit('storeSchedule', schedule)">
                            </el-date-picker>
                        </div>
                        <div style="padding-top:20px;">
                            <span>选择出行方式：</span>
                            <el-radio-group v-model="travelMode" @change="$store.commit('storeTravelMode', travelMode)">
                                <el-radio :label="3">铁路</el-radio>
                                <el-radio :label="6">飞机</el-radio>
                                <el-radio :label="9">自驾车</el-radio>
                                <el-radio :label="1">未确定</el-radio>
                            </el-radio-group>
                        </div>
                        <div style="padding-top:20px;">
                            <!-- todo: 加上一个判断，若上面并非选择铁路或飞机出行，查询按钮设为禁用 -->
                            <span>是否需要票务查询：</span>
                            <el-switch v-model="ticketingInquiry" active-color="#2A97FF" inactive-color="#E8EEF4" @change="$store.commit('storeIsTicketingInquiry', ticketingInquiry)">
                            </el-switch>
                            <span v-if="ticketingInquiry" style="padding-left:20px;color:#8F9299">请选择您打算选择的出行列车 </span>

                            <!-- TODO: 样式修改 -->
                            <div v-if="ticketingInquiry" style="padding:20px">
                                <el-table :data="ticketMsg" style="width: 100%" highlight-current-row @current-change="handleCurrentChange">
                                    <el-table-column type="expand">
                                        <template slot-scope="props">
                                            <el-form label-position="left" inline class="demo-table-expand">

                                                <el-form-item label="抵达站点">
                                                    <span>{{ props.row.to_station }}</span>
                                                </el-form-item>
                                                <el-form-item label="历时">
                                                    <span>{{ props.row.take_time }}</span>

                                                </el-form-item>
                                                <el-form-item label="座位信息">
                                                    <el-tag v-for="(value, key) in props.row.seat">{{key}} - {{value}}</el-tag>
                                                </el-form-item>
                                            </el-form>
                                        </template>
                                    </el-table-column>
                                    <el-table-column label="车次" prop="train">
                                    </el-table-column>
                                    <el-table-column label="出发站点" prop="from_station">
                                    </el-table-column>
                                    <el-table-column label="出发时间" prop="start_time">
                                    </el-table-column>
                                    <el-table-column label="抵达时间" prop="end_time">
                                    </el-table-column>
                                    <el-table-column label="描述" prop="is_same_day">
                                    </el-table-column>
                                </el-table>
                                <div style="margin-top: 20px">
                                    <el-button @click="setCurrent();" size="small">取消选择</el-button>
                                </div>
                            </div>

                        </div>
                        <p></p>

                        <div>
                            <el-button @click="nextStep();$store.commit('storeTrainSchedule', val);">下一步</el-button>
                        </div>
                    </el-collapse-item>
                    <el-collapse-item title="旅游偏好" name="4">
                        <div style="padding:20px;">
                            <span>行程宽松度：</span>
                            <el-radio-group v-model="travelComfort" size='medium' @change="$store.commit('storeTravelComfort', travelComfort);">
                                <el-radio-button :label="3">
                                    <p>宽松安排</p>
                                    <p>每天游玩4-6小时</p>
                                </el-radio-button>
                                <el-radio-button :label="6">
                                    <p>适中安排</p>
                                    <p>每天游玩7-10小时</p>
                                </el-radio-button>
                                <el-radio-button :label="9">
                                    <p>紧凑安排</p>
                                    <p>每天游玩11-16小时</p>
                                </el-radio-button>
                            </el-radio-group>

                        </div>
                        <div style="padding:20px;">
                            <span>酒店奢华度：</span>
                            <el-radio-group v-model="hotelType" size='medium'>
                                <el-radio-button :label="1">
                                    <p>经济型</p>
                                    <p>无星~2星</p>
                                </el-radio-button>
                                <el-radio-button :label="2">
                                    <p>普通型</p>
                                    <p>3~4星</p>
                                </el-radio-button>
                                <el-radio-button :label="3">
                                    <p>奢华型</p>
                                    <p>5星</p>
                                </el-radio-button>
                                <el-radio-button :label="4">
                                    <p>客栈/民宿</p>
                                    <p>-</p>
                                </el-radio-button>
                            </el-radio-group>
                        </div>
                        <hr/>
                        <div style="padding-top:20px;">
                            <router-link to="/plan/resultTravel">
                                <el-button type="" class="isSubmit">开始规划</el-button>
                            </router-link>

                        </div>
                    </el-collapse-item>
                </el-collapse>
            </el-col>
            <el-col :span="10">
                <div style="background-color:#FFFFFF; padding:20px">
                    <!-- 判断，是否有数据，否则不显示 -->
                    <!-- 列表展示从store中存储的数据 -->
                    <el-card class="box-card" style="line-height:20px;text-align:left; padding-top:10px; color:#636363">
                        <div slot="header" class="clearfix">
                            <span>从store中获取的值（暗示数据都是从store中获取的）</span>
                        </div>

                        <div style="padding-top:12px">
                            <span>选择目标城市：</span>
                            {{storeSelectCity}}
                            <hr/>
                        </div>

                        <div style="padding-top:12px">
                            <span>意愿游玩类型：</span>
                            {{storeSelectPointType}}
                            <hr/>
                        </div>

                        <div style="padding-top:12px">
                            <span>日程选择：</span>
                            {{storeSelectSchedule}}
                            <hr/>
                        </div>

                        <div style="padding-top:12px">
                            <span>出行方式：</span>
                            {{storeSelectTravelMode}}
                            <hr/>
                        </div>

                        <div style="padding-top:12px">
                            <span>票务查询：</span>
                            {{storeIsTicketingInquiry}}
                            <hr/>
                        </div>

                        <!-- 当票务查询为true是 -->
                        <div style="padding-top:12px" v-if="storeIsTicketingInquiry">
                            <span>选择列车：</span>
                            {{storeSelectTrainSchedule}}
                            <hr/>
                        </div>
                        <div style="padding-top:12px">
                            <span>行程宽松度：</span>

                            <hr/>
                        </div>
                        <div style="padding-top:12px">
                            <span>酒店奢华度：</span>

                            <hr/>
                        </div>
                    </el-card>

                </div>
            </el-col>
        </el-row>
    </div>
</template>

<script>
// 使用store
import store from '@/components/store/store.js'
export default {
  data() {
    return {
      // 选择行程舒适度
      travelComfort: '',
      //   选择酒店类型
      hotelType: '',

      // 选择行数
      currentRow: null,
      activeName: '4',
      cityData: [
        {
          value: 'xiamen',
          label: '厦门'
        },
        {
          value: 'guangzhou',
          label: '广州'
        },
        {
          value: 'chengdu',
          label: '成都'
        }
      ],
      selectedCity: '',

      pointTypeList: [],

      // 日程
      schedule: '',
      //   出行方式
      travelMode: '',
      //   票务查询
      ticketingInquiry: true
    }
  },
  computed: {
    //   获取票价信息
    ticketMsg() {
      return this.$store.state.ticketMsg
    },

    pointType() {
      return this.$store.state.typeList
    },
    recPointType() {
      return (this.recType = this.$store.getters.storeRecPointType)
    },
    commonPointType() {
      return (this.comType = this.$store.getters.storeCommonPointType)
    },

    //   获取store中选择的城市名称
    storeSelectCity() {
      let name = this.$store.state.selectCityVal
      let transDict = this.$store.state.transDict
      let res = ''
      transDict.forEach((item, index) => {
        if (item.name == name) {
          res = item.transName
        }
      })
      return res
    },
    // 获取store中选择的景点类别的值
    storeSelectPointType() {
      return this.$store.state.selectType
    },
    // 获取store中选择的旅行舒适度选项
    storeSelectTravelComfort() {
      return this.$store.state.travelComfort
    },
    storeSelectSchedule() {
      return this.$store.state.schedule
    },
    storeSelectTravelMode() {
      return this.$store.state.travelMode
    },
    //   store是否票务查询
    storeIsTicketingInquiry() {
      return this.$store.state.isTicketingInquiry
    },
    // 列车班次选择
    storeSelectTrainSchedule() {
      return this.$store.state.selectTrainSchedule
    }
  },

  methods: {
    //   test
    showType() {
      alert(this.travelComfort)
    },
    //   选择列车行信息
    //   拼接成另一个json结构？
    handleCurrentChange(val) {
      return (this.currentRow = val)
      //   return $store.commit('storeTrainSchedule', val)
    },
    // 取消列车行选择
    setCurrent(row) {
      //   this.$refs.singleTable.setCurrentRow(row);
      return (this.currentRow = null)
    },
    nextStep() {
      this.activeName = String(parseInt(this.activeName) + 1)
    }

    // ticketInformation(mode) {
    //   alert('出行方式为：' + mode)
    // }
  },
  store
}
</script>

<style scoped>
#plan {
  min-height: 420px;
}

.coll {
  text-align: left;
  /* padding-left: 20px; */
  text-indent: 10px;
}
.img {
  width: 100%;
  height: 150px;

  display: block;
}
</style>
