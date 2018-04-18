<template>
    <div id="dayTravelDetail">

        <el-card :body-style="{ padding: '0px' }" shadow="hover">
            <div slot="header" class="aDay">
                <div>日期</div>
                <div>地点</div>
                <div>行程安排</div>
            </div>
            <div v-for="i in 6" style="margin-top: 20px;margin-bottom: 20px;" class="dayItem">
                <a href="javascript:void(0);" class="itemTitle" @click="notice">
                    <i class="el-icon-star-off"></i>
                    安排{{i}}
                </a>
                <div class="itemTraffic">
                    123
                </div>
            </div>
        </el-card>

    </div>
</template>

<script>
export default {
  methods: {
    notice() {
      this.$notify({
        title: 'HTML 片段',
        dangerouslyUseHTMLString: true,
        message:
          '<div style="height:200px;width:150px;"><strong>这是 <i>HTML</i> 片段</strong></div>',
        duration: 0,
        offset: 110
        
      })
    }
  }
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
  height: 80px;
  width: 500px;
}

.dayItem {
  padding: 0;

  text-align: left;
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
</style>

