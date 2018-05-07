<template>
    <div id="dataDec">
        <!-- <el-col :span="5"> -->
          
        <el-card :body-style="{ padding: '0px'}" shadow="hover">
            <div class="list" v-for="item in storeDataList">
                <div class="iconDay" @click="test()">
                    D{{item.day}}
                </div>
                <div class="dataSim">
                    <p>{{item.travelDate}}</p>
                    <p v-if="item.from_city != null">{{item.from_city}} => {{item.to_city}}</p>
                    <p v-else>{{item.to_city}}</p>
                </div>
            </div>
            

        </el-card>
        <!-- <p>
          {{storeDataList}}
        </p> -->
        <!-- </el-col> -->
    </div>
</template>

<script>
import store from '@/components/store/store.js'
export default {
  data(){
    return {
      isShow : true
    }
  },
  computed:{
    // 从store中获取日期出行列表
    storeDataList(){
      return this.$store.state.travelDateList
    }
  },
  methods:{
    test(){
      alert('asdasdsad');
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
