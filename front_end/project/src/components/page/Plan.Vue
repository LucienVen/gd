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
                            <el-date-picker v-model="schedule" type="daterange" range-separator="至" start-placeholder="开始日期" end-placeholder="结束日期" value-format="yyyy-MM-dd">
                            </el-date-picker>
                        </div>
                        <div style="padding-top:20px;">
                            <span>选择出行方式：</span>
                            <el-radio-group v-model="travelMode" @change="ticketInformation(travelMode)">
                                <el-radio :label="3">铁路</el-radio>
                                <el-radio :label="6">飞机</el-radio>
                                <el-radio :label="9">自驾车</el-radio>
                            </el-radio-group>
                        </div>
                        <p></p>

                        <div>
                            <el-button @click="nextStep">下一步</el-button>
                        </div>
                    </el-collapse-item>
                    <el-collapse-item title="住宿选项" name="4">
                        <div>用户决策：根据场景可给予用户操作建议或安全提示，但不能代替用户进行决策；</div>
                        <div>结果可控：用户可以自由的进行操作，包括撤销、回退和终止当前操作等。</div>
                        <div>结果可控：用户可以自由的进行操作，包括撤销、回退和终止当前操作等。</div>
                        <div>结果可控：用户可以自由的进行操作，包括撤销、回退和终止当前操作等。</div>
                        <div>结果可控：用户可以自由的进行操作，包括撤销、回退和终止当前操作等。</div>
                        <div>结果可控：用户可以自由的进行操作，包括撤销、回退和终止当前操作等。</div>
                        <div>结果可控：用户可以自由的进行操作，包括撤销、回退和终止当前操作等。</div>
                        <div>结果可控：用户可以自由的进行操作，包括撤销、回退和终止当前操作等。</div>
                        <div>结果可控：用户可以自由的进行操作，包括撤销、回退和终止当前操作等。</div>
                        <div>结果可控：用户可以自由的进行操作，包括撤销、回退和终止当前操作等。</div>
                        <div>结果可控：用户可以自由的进行操作，包括撤销、回退和终止当前操作等。</div>
                        <div>结果可控：用户可以自由的进行操作，包括撤销、回退和终止当前操作等。</div>
                        <div>结果可控：用户可以自由的进行操作，包括撤销、回退和终止当前操作等。</div>
                        <div>
                            <el-button type="" class="isSubmit">开始规划</el-button>
                        </div>
                    </el-collapse-item>
                </el-collapse>
            </el-col>
            <el-col :span="10">
                <div style="background-color:#FFFFFF;">
                    <!-- 判断，是否有数据，否则不显示 -->
                    <div>
                        <p>{{storeSelectCity}}</p>
                        <p>{{storeSelectPointType}}</p>
                        <p>日程：{{schedule}}</p>
                        <p>出行方式：{{travelMode}}</p>

                    </div>
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
      activeName: '3',
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
      travelMode: ''
    }
  },
  computed: {
    pointType() {
      return this.$store.state.typeList
    },
    recPointType() {
      return (this.recType = this.$store.getters.storeRecPointType)
    },
    commonPointType() {
      return (this.comType = this.$store.getters.storeCommonPointType)
    },

    indexPointType() {
      let index = this.$store.getters.storeCommonPointType
      index.forEach((element, index) => {
        console.log(element)
      })
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
    }
  },

  methods: {
    nextStep() {
      this.activeName = String(parseInt(this.activeName) + 1)
    },
    
    ticketInformation(mode){
        alert("出行方式为："+mode);
    }

    
  },

  //   created: {
  //     function() {
  //       let index = this.$store.getters.storeCommonPointType
  //       index.forEach((element, index) => {
  //         console.log(element)
  //       })
  //     }
  //   },
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
