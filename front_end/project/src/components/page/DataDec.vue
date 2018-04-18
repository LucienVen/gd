<template>
    <div id="dataDec">
        <!-- <el-col :span="5"> -->
        <el-card :body-style="{ padding: '0px'}" shadow="hover">
            <div class="list" v-for="item in 4">
                <div class="iconDay">
                    D{{item}}
                </div>
                <div class="dataSim" v-if="isShow">
                    <p>出发日期</p>
                    <p>地点</p>
                </div>
            </div>

        </el-card>
        <!-- </el-col> -->
    </div>
</template>

<script>
export default {
  data(){
    return {
      isShow : false
    }
  }
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
  background-color: darkslategrey;
  float: left;
  width: 70px;
  height: 70px;
  border-radius: 50%;
  margin-top: 15px;
  margin-left: 15px;
  line-height: 70px;
  color: #ffffff;
  font-size: 24px;
}
.dataSim {
  background-color: darkseagreen;
  height: 100%;
  padding-top: 30px;
}

.dataSim p {
  margin: 0%;
}
</style>
