<template>
  <div id="about">
    <h1>{{ msg }}</h1>
    <p>测试，从store中读取数据？list in 操作</p>
    <el-button @click="check('aaa')">test</el-button>
    <!-- <el-button @click="check('aaa')">asdxzc</el-button> -->
    <h3>{{data.username}}</h3>
    <h3>{{data.data.username}}</h3>

    <div>
      <div class="block">
        <span class="demonstration">可选择任意一级菜单的选项</span>
        <el-cascader v-model="ss" placeholder="试试搜索：指南" :options="options" filterable change-on-select></el-cascader>
      </div>

    </div>
    <!-- {{ss}}
    <p>{{code2city}}</p> -->
    {{options}}
  </div>
</template>

<script>
import { pca } from '../../static/js/pca'
export default {
  data() {
    return {
      ss: [],
      // code2city:[],
      options: [],
      selected: [],
      msg: 'About us',
      data: {
        username: 123,
        password: 'qwe',
        data: {
          uid: 1,
          username: 'YvenChang@gmail.com',
          root: 1,
          status: 0,
          create_time: 1521609634,
          update_time: 1521609634,
          is_delete: 0
        }
      }
    }
  },
  
  computed: {
    
  },
  methods: {
    check(value) {
      var temp = [1, 2, 3, 4, 'aaa', 'test']
      if (temp.includes(value)) {
        alert('su')
      }
    }
  },
  mounted() {
    var option = []
    for (var i in pca) {
      // let res = {}
      // console.log(pca[i])
      if (i == '86') {
        for (var j in pca[i]) {
          let res = {}
          res['value'] = j
          res['label'] = pca[i][j]
          option.push(res)
        }
      } else {
        for (var k in option) {
          if (i == option[k].value) {
            let children = []
            for (var m in pca[i]) {
              let res2 = {}
              res2['value'] = j
              res2['label'] = pca[i][m]
              children.push(res2)
            }
            // children.push(res2)
            option[k]['children'] = children
          }
        }
      }
    }
    this.options = option

    for (var i in option) {
      console.log(option[i].value)
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
#about {
  height: 360px;
}
</style>
