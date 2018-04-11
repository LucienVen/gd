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
                                        <span>广州</span>
                                    </div>
                                </el-card>
                            </el-col>
                        </el-row>
                        <div>
                            <el-button @click="nextStep; $store.commit('storeSelectedCity', selectedCity)">下一步</el-button>
                        </div>

                    </el-collapse-item>
                    <el-collapse-item title="选择意愿游玩景点类型（可不选）" name="2">
                        <div>控制反馈：通过界面样式和交互动效让用户可以清晰的感知自己的操作；</div>
                        <div>页面反馈：操作后，通过页面元素的变化清晰地展现当前状态。</div>
                        <div>
                            <el-button @click="nextStep">下一步</el-button>
                        </div>
                    </el-collapse-item>
                    <el-collapse-item title="游玩选项" name="3">
                        <div>简化流程：设计简洁直观的操作流程；</div>
                        <div>清晰明确：语言表达清晰且表意明确，让用户快速理解进而作出决策；</div>
                        <div>帮助用户识别：界面简单直白，让用户快速识别而非回忆，减少用户记忆负担。</div>
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
                        {{storeSelectCity}}
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
      activeName: '1',
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
      selectedCity: ''
    }
  },
  computed: {
    storeSelectCity() {
      let name = this.$store.state.selectCityVal;
      let transDict = this.$store.state.transDict;
      let res = '';
      transDict.forEach((item, index) => {
          if(item.name == name){
              res = item.transName
          }
      });

      return res;
    }
  },

  methods: {
    
    nextStep() {
      this.activeName = String(parseInt(this.activeName) + 1)
    }
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
