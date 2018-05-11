<template>
  <div id="layoutNav">
    <el-menu :default-active="activeIndex" class="el-menu-demo" mode="horizontal" background-color="#162439" text-color="#fff" active-text-color="#ffd04b">
      <el-menu-item index="1" id="title">
        <i class="el-icon-edit"></i>
        <router-link to="/">TOUR PLAN</router-link>
      </el-menu-item>
      <el-submenu v-if="checkLogin" index="2" class="menu-item">
        <template slot="title">{{showID}}</template>
        <!-- <template v-else slot="title">{{user}}</template> -->
        <router-link to="/person">
          <el-menu-item index="2-1">个人中心</el-menu-item>
        </router-link>
        <el-menu-item index="2-2" @click="logOut">退出登录</el-menu-item>
      </el-submenu>
      <el-submenu v-else index="2" class="menu-item">
        <template slot="title">MENU</template>
        <!-- <template v-else slot="title">{{user}}</template> -->
        <!-- <el-menu-item index="2-1">个人中心</el-menu-item> -->
        <router-link to="/registered">
          <el-menu-item index="2-1">登录 / 注册</el-menu-item>
        </router-link>
      </el-submenu>
      <router-link to="/about">
        <el-menu-item index="4" class="menu-item">About</el-menu-item>
      </router-link>
    </el-menu>

  </div>
</template>

<script>
// import Login from './Login'
// import About from './About'
import store from '@/components/store/store.js'
// import { mapState } from 'vuex'
import axios from 'axios'
axios.defaults.withCredentials = true
export default {
  data() {
    return {
      activeIndex: '1',
      msg: 'Hello, world',
      username: '',
      // username: '',
      isLogin: false
    }
  },
  computed: {
    checkLogin() {
      if (this.username != '') {
        return (this.isLogin = true)
      }
    },
    showID() {
      let username = this.$store.state.username
      if (username !== '') {
        return username
      } else {
        return this.$store.state.email
      }
    }
  },

  mounted() {
    let that = this
    console.log(that.msg)
    console.log(that.username)

    axios
      .get(this.GLOBAL.apiurl+'user')
      .then(function(response) {
        // 更新store
        that.username = response.data.data.username
        that.$store.commit('storeUid', response.data.data.uid)
        console.log(that.$store.state.uid)
        that.$store.commit('storeEmail', response.data.data.email)

        that.$store.commit('storeUserName', response.data.data.username)
        // console.log(that.$store.state.username)
      })
      .catch(function(error) {
        console.log(error)
      })
  },
  methods: {
    // 注销
    logOut() {
      let that = this
      axios({
        method: 'delete',
        url: this.GLOBAL.apiurl+'auth',
        withCredentials: true
      }).then(function(response) {
        // 更新store？
        // alert('退出成功！')
        that.$message({
          showClose: true,
          message: '注销成功',
          type: 'success'
        })
        // 跳转之后会刷新store了
        window.location.href = 'http://localhost:8080'
      })
    },
    hello() {
      alert('Hello, world!!')
    }
  },
  store

  // components: {
  //   'log-in': Login,
  //   'about': About
  // }
}
</script>

<style scoped>
#layoutNav {
  width: 100%;
  position: fixed;
  /* 图层问题，值越大就在越上方 */
  z-index: 99;
}
.menu-item {
  float: right;
}

#title {
  font-weight: bolder;
  font-size: 16px;
}
</style>
