<template>

  <div id="personal">

    <!-- <h1>{{ msg }}</h1> -->
    <!-- <h1>{{getStoreUid}}</h1> -->
    <el-row :gutter="20" style="margin-top:50px;">
      <el-col :span="4" :offset="4">
        <span style="text-align:right">
          <b style="margin-right:4px;">已保存规划数:</b> {{countPlan}}</span>
      </el-col>
      <el-col :span="6">
        <span style="text-align:left">
          <b style="margin-right:4px;">email:</b> {{getStoreEmail}}</span>
      </el-col>
      <el-col :span="6">
        <span style="text-align:center">
          <b style="margin-right:4px;">username:</b> {{getStoreUserName}}</span>
        <el-button type="mini" @click="dialogFormVisible = true">修改</el-button>
      </el-col>

      <el-dialog title="修改用户名" :visible.sync="dialogFormVisible">

        <el-input v-model="newUserName" :placeholder={getStoreUserName}>
          <template slot="prepend">请输入新用户名：</template>
        </el-input>
        <div slot="footer" class="dialog-footer">
          <el-button @click="dialogFormVisible = false">取 消</el-button>
          <el-button type="primary" @click="dialogFormVisible=false;updateUserName(newUserName)">确 定</el-button>
        </div>
      </el-dialog>

      </el-col>
      <el-col :span="16" :offset="4">
        <hr />
      </el-col>

      <el-col :span="16" :offset="4" style="margin-top: 20px;margin-bottom:50px;">
        <!-- 路线规划表格 -->
        <el-table :data="userPlanData" stripe style="width: 100%;text-align: left;">
          <el-table-column prop="id" label="序号">
          </el-table-column>
          <el-table-column prop="go_off" label="出发日期">
          </el-table-column>
          <el-table-column prop="cost_time" label="出行天数">
          </el-table-column>
          <el-table-column prop="name" label="规划名称">
          </el-table-column>
          <el-table-column prop="description" label="规划简介">
          </el-table-column>
          <el-table-column fixed="right" label="操作" width="150">
            <template slot-scope="scope">
              <router-link to="/plan/resultTravel">
                <el-button @click="hello(scope.row);getPlanRes(scope.row)" type="" size="small">查看</el-button>
              </router-link>
              <el-button @click="delUserPlan(scope.row.id)" type="danger" size="mini">删除</el-button>
            </template>
          </el-table-column>

        </el-table>

      </el-col>
    </el-row>

  </div>

</template>

<script>
import axios from 'axios'
import store from '@/components/store/store.js'
axios.defaults.withCredentials = true
export default {
  data() {
    return {
      dialogFormVisible: false,

      msg: 'hello, world!',
      userPlanData: '',
      newUserName: '',
      changeUserName: false
    }
  },
  computed: {
    countPlan() {
      // if (this.userPlanData.length == 0) {
      //   return 0
      // } else {
      return this.userPlanData.length
      // }
    },

    getStoreEmail() {
      return this.$store.state.email
    },
    getStoreUserName() {
      return this.$store.state.username
    }
  },
  methods: {
    // test
    hello(data) {
      alert(data.id)
      console.log(data.id)
    },
    // 获取uid
    getStoreUid() {
      return this.$store.state.uid
    },
    // 更改用户名
    updateUserName(data) {
      let uid = this.getStoreUid()
      let that = this
      axios({
        method: 'put',
        url:
          'http://localhost:8089/gd/back_end/public/index.php/v1/user/' + uid,
        data: { username: that.newUserName },
        withCredentials: true
      })
        .then(function(response) {
          that.$store.commit('storeUserName', that.newUserName)

          that.$message({
            showClose: true,
            message: '更改用户名成功！',
            type: 'success'
          })
        })
        .catch(function(response) {
          alert('trouble!')
        })
    },
    // 删除用户某次路径规划信息
    delUserPlan(p_id) {
      // http://localhost:8089/gd/back_end/public/index.php/v1/plan/1
      let that = this
      axios({
        method: 'delete',
        url:
          'http://localhost:8089/gd/back_end/public/index.php/v1/plan/' + p_id,
        withCredentials: true
      })
        .then(function(response) {
          that.$message({
            showClose: true,
            message: '删除规划成功!',
            type: 'success'
          })
          that.reload()
          // that.$root.reload()
        })
        .catch(function(response) {
          that.$message({
            showClose: true,
            message: '删除不成功',
            type: 'error'
          })
        })
      // this.$root.reload()
      


      // this.$nextTick(function () {
      //   console.log(this.$el.textContent)
      // })
      // alert('删除用户信息')
    },
    // 获取user保存的所有路径规划信息

    componentUpdated: function() {
      this.delUserPlan()
    },

    getUserPlan() {
      let that = this
      axios
        .get('http://localhost:8089/gd/back_end/public/index.php/v1/plan')
        .then(function(response) {
          // console.log(response.data.data)
          that.userPlanData = response.data.data.data
        })
        .catch(function(error) {
          console.log(error)
        })
    },
    // 获取规划日程
    getPlanRes(index) {
      let that = this
      // console.log(typeof(index))
      axios({
        method: 'get',
        url:
          'http://localhost:8089/gd/back_end/public/index.php/v1/plan/' +
          index.id,
        withCredentials: true
      })
        .then(function(response) {
          that.$store.commit('storeTestPlanRes', response.data.data)
          alert('ojbk！')
        })
        .catch(function(response) {
          alert('trouble!')
        })
    }
  },
  mounted() {
    this.getUserPlan()
  },
  inject: ['reload'],

  store
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
#personal {
}
</style>
