<template>
  <div id="app">

    <el-container>
      <el-header width="100%">
        <layout-nav></layout-nav>
      </el-header>
      <el-main>
        <!-- <img src="./assets/logo.png"> -->
        <router-view/>
      </el-main>
      <el-footer style="height:300px; width:100%;">
        <layout-footer></layout-footer>
      </el-footer>
    </el-container>

  </div>
</template>

<script>
import LayoutNav from './components/LayoutNav'
import LayoutFooter from './components/LayoutFooter'
export default {
  name: 'App',
  components:{
    'layout-nav': LayoutNav,
    'layout-footer': LayoutFooter
  }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  /* margin-top: 60px; */
}
.el-header{
  background-color: #162439;
  color: #333;
  text-align: center;
  padding: 0;
  /* line-height: 60px; */
}

.el-footer {
  background-color: #162439;
  color: #333;
  text-align: center;
  padding: 0;
  
  /* line-height: 60px; */
}

/* .el-footer{
  height: 300px;
} */

.el-main {
  background-color: #e9eef3;
  color: #333;
  text-align: center;
  line-height: 160px;
  
  
}
</style>
