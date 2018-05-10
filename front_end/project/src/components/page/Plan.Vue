<template>
  <div id="plan">
    <el-row :gutter="20">
      <el-col :span="14" :offset="1">
        <el-collapse v-model="activeName" accordion class="coll">
          <el-collapse-item title="城市选择" name="1">
            <el-row style="padding-left:40px;" :gutter="20">
              <!-- {{beginCityCode}}
                            {{selectedCity}} -->
              <el-col :span="24">
                <div class="block">
                  <span style="color:red">* </span>
                  <span class="demonstration">选择出发城市</span>
                  <!-- {{beginCityName}} -->
                  <el-cascader v-model="beginCityCode" @change="cityCode2CityName" placeholder="选择出发城市" @blur="$store.commit('storeBeginCity', beginCityName);" :options="options" filterable change-on-select></el-cascader>

                </div>
              </el-col>

            </el-row>
            <div style='width:80%; margin-top:20px;margin-left:50px;'><hr /></div>
            <el-row style="padding-left:40px; margin-top:20px;" :gutter="20">
              <el-col :span="24">
                <span style="color:red">* </span>
                <span>选择出行城市: </span>
                <el-select v-model="selectedCity" filterable placeholder="请选择" @blur="$store.commit('storeSelectedCity', selectedCity);">
                  <el-option v-for="item in cityData" :key="item.value" :label="item.label" :value="item.value">
                  </el-option>
                </el-select>
              </el-col>

            </el-row>
            <el-row style="padding:30px;" :gutter="20">
              <el-col :span="8" v-for="city in cityData" @click.native='ClickCity(city.value);'>
                <el-card :body-style="{padding:'0px'}" shadow="hover">
                  <img class="img" :src="city.img">
                  <div style="padding:14px;">
                    <span>{{city.label}}</span>
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
              <el-switch v-model="ticketingInquiry" active-color="#2A97FF" inactive-color="#E8EEF4" @change="getTrainMsg();">
              </el-switch>
              <span v-if="ticketingInquiry" style="padding-left:20px;color:#8F9299">请选择您打算选择的出行列车 </span>

              <!-- TODO: 样式修改 -->
              <div v-if="ticketingInquiry" style="padding:20px">
                <el-table :data="trainTicketList" style="width: 100%" highlight-current-row @current-change="handleCurrentChange" v-loading="loading">
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
                          <el-tag v-for="(value, key) in props.row.seat">{{value['seat_type']}} - {{value['seat_price']}}</el-tag>
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
              <el-radio-group v-model="travelComfort" size='medium' v-for="comfort in travelComfortData" @change="$store.commit('storeTravelComfort', travelComfort);">
                <el-radio-button :label="comfort.label">
                  <p>{{comfort.type}}</p>
                  <p>{{comfort.dec}}</p>
                </el-radio-button>
              </el-radio-group>

            </div>
            <div style="padding:20px;">
              <span>酒店奢华度：</span>
              <el-radio-group v-model="hotelType" size='mini' v-for="hotel in hotelTypeData" @change="$store.commit('storeHotelType', hotel.label)">
                <el-radio-button :label="hotel.label">
                  <p>{{hotel.type}}</p>
                  <p>{{hotel.dec}}</p>
                </el-radio-button>

              </el-radio-group>
            </div>
            <hr/>
            <div style="padding-top:20px;">
              <router-link to="/plan/resultTravel">
                <el-button type="" class="isSubmit" @click="getPlanRes">开始规划</el-button>

              </router-link>
              <el-button type="" @click='dumpStep'>test</el-button>

            </div>
          </el-collapse-item>
        </el-collapse>
      </el-col>
      <el-col :span="8">
        <div style="background-color:#FFFFFF; padding:20px">
          <!-- 判断，是否有数据，否则不显示 -->
          <!-- 列表展示从store中存储的数据 -->
          <el-card class="box-card" style="line-height:20px;text-align:left; padding-top:10px; color:#636363">
            <div slot="header" class="clearfix">
              <span>选项：</span>
              <el-button size="mini" style="float:right" @click="resetPageData();$store.commit('reset');">重置</el-button>
            </div>
            <div style="padding-top:12px">
              <span>选择出发城市：</span>
              {{storeSelectBeginCity}}
              <hr/>
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
              {{ticketingInquiry}}
              <hr/>
            </div>

            <!-- 当票务查询为true是 -->
            <div style="padding-top:12px" v-if="ticketingInquiry">
              <span>选择列车：</span>
              {{storeSelectTrainSchedule}}
              <hr/>
            </div>
            <div style="padding-top:12px">
              <span>行程宽松度：</span>
              {{storeSelectTravelComfort}}
              <hr/>
            </div>
            <div style="padding-top:12px">
              <span>酒店奢华度：</span>
              {{storeHotelType}}
              <hr/>
            </div>
          </el-card>
          <p>{{pointTypeList}}</p>
          <p>{{selectedCity}}</p>
          <el-button :plain="true" @click="dumpStep">打开消息提示</el-button>
          <el-button @click="notice('城市未选择')">notice</el-button>
          <!-- <img src='../../assets/city/xiamen.jpeg'> -->
        </div>
      </el-col>
    </el-row>
    <!-- {{options}} -->
  </div>
</template>

<script>
import axios from 'axios'
// 使用store
import store from '@/components/store/store.js'
// 省市json
import { pca } from '../../../static/js/pcaOption'
export default {
  data() {
    return {
      // train ticket list
      trainTicketList: '',
      loading: true,
      // 开始规划？
      beginPlan: false,
      // 省市级联
      options: pca,
      // 出发城市
      beginCityCode: '',
      beginCityName: '',

      // 选择行数
      currentRow: null,
      activeName: '3',
      cityData: [
        {
          value: 'xiamen',
          label: '厦门',
          //   img: '../../assets/city/xiamen.jpeg'
          img: '../../../static/city/xiamen.jpeg'
        },
        {
          value: 'guangzhou',
          label: '广州',
          //   img: '../../assets/city/guangzhou.jpg'
          img: '../../../static/city/guangzhou.jpg'
        },
        {
          value: 'chengdu',
          label: '成都',
          //   img: '../../assets/city/chengdu.jpg'
          img: '../../../static/city/chengdu.jpeg'
        }
      ],
      selectedCity: '',

      pointTypeList: [],

      // 日程
      schedule: '',
      //   出行方式
      travelMode: '',
      //   票务查询
      ticketingInquiry: false,

      // 选择行程舒适度
      travelComfort: '',
      travelComfortData: [
        {
          label: 1,
          type: '宽松安排',
          dec: '每天游玩4-6小时'
        },
        {
          label: 2,
          type: '适中安排',
          dec: '每天游玩7-10小时'
        },
        {
          label: 3,
          type: '紧凑安排',
          dec: '每天游玩11-16小时'
        }
      ],
      //   选择酒店类型
      hotelType: '',
      hotelTypeData: [
        {
          label: 1,
          type: '经济型',
          dec: '无星~2星'
        },
        {
          label: 2,
          type: '普通型',
          dec: '3~4星'
        },
        {
          label: 3,
          type: '奢华型',
          dec: '5星'
        },
        {
          label: 4,
          type: '客栈/民宿',
          dec: '-'
        }
      ]
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
    // 选择出发城市
    storeSelectBeginCity() {
      return this.$store.state.beginCity
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
    // storeIsTicketingInquiry() {
    //   return this.$store.state.isTicketingInquiry
    // },
    // 列车班次选择
    storeSelectTrainSchedule() {
      return this.$store.state.selectTrainSchedule
    },
    storeHotelType() {
      return this.$store.state.hotelType
    }
  },

  methods: {
    // 请求列车信息
    trainMsg(start, end, time) {
      var that = this
      axios({
        method: 'post',
        url: 'http://localhost:8089/gd/back_end/public/index.php/v1/train',
        data: {
          start: start,
          end: end,
          time: time
        },
        // data: params,
        withCredentials: true
      }).then(function(response) {
        console.log(response.data.data);
        // 更新store
        that.trainTicketList = response.data.data
        that.loading = false
        alert('ojbk')
        // window.location.href = 'http://localhost:8080/#/login'
      })
    },
    // notice
    notice(msg, act) {
      this.$message({
        showClose: true,
        center: true,
        message: msg,
        type: 'warning'
      })
      this.activeName = act
    },
    // 进行爬虫票务查询 start, end, time
    getTrainMsg() {
      // 检查选项
      if (this.storeSelectTravelMode == '3' && this.ticketingInquiry == true) {
        // 检查参数
        // alert(this.storeSelectBeginCity)
        if (this.storeSelectBeginCity == '') {
          this.notice('出发城市未选择', '1')
          this.ticketingInquiry = false
          // return 0
        } else if (this.storeSelectCity == '') {
          this.notice('目标城市未选择', '1')
          this.ticketingInquiry = false
          // return 0
        } else if (this.storeSelectTravelMode == '') {
          this.notice('出发方式未选择', '3')
          this.ticketingInquiry = false
          // return 0
        } else {
          let begin = this.storeSelectBeginCity[1].substr(0, 2)
          let end = this.storeSelectCity
          let time = this.storeSelectSchedule[0]
          alert(begin + ' / ' + end + ' / ' + time)
          this.trainMsg(begin, end, time)
        }
        // alert(this.storeSelectCity)
        // alert(this.storeSelectTravelMode)
      } else {
        this.notice('出行方式未选择', '3')
        // alert('trouble!')
        this.ticketingInquiry = false
      }
    },

    // 获取规划日程
    getPlanRes() {
      let that = this
      axios({
        method: 'get',
        url: 'http://localhost:8089/gd/back_end/public/index.php/v1/plan/8',
        withCredentials: true
      }).then(function(response) {
        // that.testTravelData = response.data.data
        // that.$store.
        that.$store.commit('storeTestPlanRes', response.data.data)
        alert('ojbk！')
        // window.location.href='http://localhost:8080'
      })
    },

    //  转换出发城市代号-> 城市名
    cityCode2CityName() {
      let code = this.beginCityCode
      let option = this.options
      let cityName = []
      for (let j in option) {
        if (code[0] == option[j]['value']) {
          cityName.push(option[j]['label'])
          for (let m in option[j]['children']) {
            if (code[1] == option[j]['children'][m]['value']) {
              cityName.push(option[j]['children'][m]['label'])
            }
          }
        }
      }
      return (this.beginCityName = cityName)
    },

    resetPageData() {
      //   return (
      this.activeName = '3'
      this.loading = true
      // 城市
      // this.selectCityVal = ''
      // this.beginCityCode = ''
      // this.beginCityName = ''
      // 景点
      this.pointTypeList = []
      // 日程
      this.schedule = ''
      // 出行方式
      this.travelMode = ''
      // 票务查询
      this.ticketingInquiry = false
      // 宽松度
      this.travelComfort = ''
      // 奢华度
      this.hotelType = ''
    },
    hello() {
      alert('hello, world!')
    },
    ClickCity(city) {
      this.selectedCity = city
      //   alert('Hello,' + city + ' !')
    },
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
    },

    dumpStep() {
      if (this.storeSelectBeginCmsgity == '' && this.storeSelectCity === '') {
        this.$message({
          showClose: true,
          center: true,
          message: '城市选项未选择',
          msg: 'warning'
        })
        this.activeName = '1'
      } else if (this.storeSelectSchedule == '') {
        this.$message({
          showClose: true,
          center: true,
          message: '出行日程未选择',
          type: 'warning'
        })
        this.activeName = '3'
      } else {
        this.$message({
          showClose: true,
          center: true,
          message: '.........',
          type: 'warning'
        })
      }

      //   this.activeName = '3'
    }
    // 跳转未填写的页面
    // dumpStep() {
    //   this.activeName = '3'
    // this.activeName = '1'
    // 城市
    // if (
    //   this.selectCityVal == '' &&
    //   this.beginCityCode == '' &&
    //   this.beginCityName == ''
    // ) {
    //   this.$message({
    //     showClose: true,
    //     center: true,
    //     message: '警告哦，这是一条警告消息',
    //     type: 'warning'
    //   })
    //   this.activeName = '2'
    // }
    // this.selectCityVal = ''
    // this.beginCityCode = ''
    // this.beginCityName = ''
    // 景点
    //   this.pointTypeList = []
    //   // 日程
    //   this.schedule = ''
    //   // 出行方式
    //   this.travelMode = ''
    //   // 票务查询
    //   this.ticketingInquiry = false
    //   // 宽松度
    //   this.travelComfort = ''
    //   // 奢华度
    //   this.hotelType = ''
    // }

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
