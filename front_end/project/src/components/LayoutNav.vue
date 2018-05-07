<template>
  <div id="layoutNav">
    <el-menu :default-active="activeIndex" class="el-menu-demo" mode="horizontal" @select="handleSelect" background-color="#162439" text-color="#fff" active-text-color="#ffd04b">
      <el-menu-item index="1" id="title">
        <i class="el-icon-edit"></i>
        <router-link to="/">TOUR PLAN</router-link>
      </el-menu-item>
      <el-submenu v-if="checkLogin" index="2" class="menu-item">
        <template slot="title">{{username}}</template>
        <!-- <template v-else slot="title">{{user}}</template> -->
        <el-menu-item index="2-1">个人中心</el-menu-item>
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
    }
  },

  mounted() {
    let that = this
    console.log(that.msg)
    console.log(that.username)

    axios
      .get('http://localhost:8089/gd/back_end/public/index.php/v1/user')
      .then(function(response) {
        that.username = response.data.data.username
      })
      .catch(function(error) {
        console.log(error)
      })

      
  },
  methods: {
    logOut() {
      axios
        .delete('http://localhost:8089/gd/back_end/public/index.php/v1/auth')
        .then(function(response) {
          alert(response)
        }).catch(function(response){
          console.log(response)
        })
    },
    hello() {
      alert('Hello, world!!')
    }
    // handleSelect(key, keyPath) {
    //   console.log(key, keyPath)
    // }
    // getUserInfo() {
    //   axios
    //     .get('http://localhost:8089/gd/back_end/public/index.php/v1/user')
    //     .then(function(response) {
    //       // console.log(response)
    //       // if(response.error == 0){
    //       // console.log(this.msg)
    //       // console.log(response)
    //       this.username = response.data.data.username
    //       console.log(this.username)

    //       // }
    //     })
    //     .catch(function(error) {
    //       console.log(error)
    //     })
    // }
    // getStore(){
    //   console.log($store.state.typeList)
    // }
  }
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
