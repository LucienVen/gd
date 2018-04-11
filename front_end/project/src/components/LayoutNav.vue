<template>
    <div id="layoutNav">
        <el-menu :default-active="activeIndex" class="el-menu-demo" mode="horizontal" @select="handleSelect" background-color="#162439" text-color="#fff" active-text-color="#ffd04b">
            <el-menu-item index="1" id="title">
                <i class="el-icon-edit"></i><router-link to="/">TOUR PLAN</router-link></el-menu-item>
            <el-submenu index="2" class="menu-item">
                <template slot="title">MENU</template>
                <el-menu-item index="2-1">选项1</el-menu-item>
                <el-menu-item index="2-2">选项2</el-menu-item>
                <el-menu-item index="2-3">选项3</el-menu-item>
                <!-- <el-submenu index="2-4">
                    <template slot="title">选项4</template>
                    <el-menu-item index="2-4-1">选项1</el-menu-item>
                    <el-menu-item index="2-4-2">选项2</el-menu-item>
                    <el-menu-item index="2-4-3">选项3</el-menu-item>
                </el-submenu> -->
            </el-submenu>
            <el-menu-item index="2" class="menu-item">LOGIN IN</el-menu-item>
            <el-menu-item disabled class="menu-item"> | </el-menu-item>
            <el-menu-item index="3" class="menu-item">REGISTER</el-menu-item>
            <el-menu-item disabled class="menu-item"> | </el-menu-item>
            <el-menu-item index="4" class="menu-item">ABOUT US</el-menu-item>

        </el-menu>

    </div>
</template>

<script>
export default {
  data() {
    return {
      activeIndex: '1'
    }
  },
  methods: {
      handleSelect(key, keyPath) {
        console.log(key, keyPath);
      }
    }
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
