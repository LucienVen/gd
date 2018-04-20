<template>
  <div id="dayTravelDetail">

    <el-card :body-style="{ padding: '0px' }" shadow="hover">
      <div slot="header" class="aDay">
        <!-- <p>{{diaTitle}}</p> -->
        <div>日期</div>
        <div>地点</div>
        <div>行程安排</div>
        <div>{{storeDiaTitle}}</div>
        <!-- <el-button :plain="true" @click="open5">消息</el-button>
        <el-button :plain="true" @click="open6">close</el-button>
        <el-button :plain="true" @click="closeNotice">close notice</el-button> -->
      </div>
      <div v-for="i in test" class="dayItem">
        <a href="javascript:void(0);" class="itemTitle" :key="i.name" @click="isShow();$store.commit('storeSelectDiaTitle', i.name)">
          <i class="el-icon-star-off"></i>
          {{i.name}}
        </a>
        <div class="itemTraffic">
          123
        </div>
      </div>
    </el-card>

    <!-- <view-point-dia></view-point-dia> -->

    <el-dialog :title="storeDiaTitle" :visible="dialogVisible" width="50%">
      <span>{{storeDiaTitle}}</span>
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
      diaTitle: '',
      msg: 'Hello, World!',
      dialogVisible: false,

      // notice框状态
      noticeShow: false,
      noticeMsg: 'Hello, world!',

      test: [
        { name: '景点1' },
        { name: '景点2' },
        { name: '景点3' },
        { name: '景点4' }
      ]
    }
  },
  computed: {
    // 获取store diaTitle
    storeDiaTitle() {
      console.log("computed....")
      return this.$store.state.diaTitle;
    }
  },

  methods: {
    isShow(){
      console.log("isshow...");
      return this.dialogVisible=true;
    },
    notice() {
      if (this.noticeShow) {
        // 调用关闭notice框方法
        this.closeNotice()
        // 更改notice框状态
        this.noticeShow = false
        // console.log(this.noticeShow);
      } else {
        // 创建notice实例
        this.notice = this.$notify({
          title: 'HTML 片段',
          dangerouslyUseHTMLString: true,
          message:
            '<div style="height:200px;width:150px;"><strong>这是 <i>{{noticeMsg}}</i> 片段</strong></div>',

          duration: 0,
          offset: 110
        })
        // 更改notice框状态
        this.noticeShow = true
        // console.log(this.noticeShow);
      }
    },
    // 这里可以实现点击手动关闭message
    open5() {
      this.msg = this.$message({
        showClose: true,
        message: '恭喜你，这是一条成功消息',
        duration: 0
      })
    },
    open6() {
      this.msg.close()
    },
    // 关闭notice方法
    closeNotice() {
      this.notice.close()
    }
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
  height: 80px;
  width: 500px;
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
</style>

