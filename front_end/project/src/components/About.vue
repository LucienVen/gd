<template>
  <div id="about">
    <h1>{{msg}}</h1>

    <el-button type="" @click="getPlanRes">test</el-button>
    <p>{{storeTestPlanRes}}</p>
  </div>
</template>

<script>
import axios from 'axios'
import store from '@/components/store/store.js'
import { pca } from '../../static/js/pca'
import { ticket } from '../../static/js/ticket'
export default {
  data() {
    return {
      msg: 'hello, world!'
    }
  },
  computed: {
    storeTestPlanRes() {
      return this.$store.state.testPlanRes
    }
  },
  methods: {
    getPlanRes() {
      let that = this
      axios({
        method: 'get',
        url: 'http://localhost:8089/gd/back_end/public/index.php/v1/plan/1',
        withCredentials: true
      }).then(function(response) {
        // that.testTravelData = response.data.data
        // that.$store.
        that.$store.commit('storeTestPlanRes', response.data.data)
        alert('ojbk！')
        // window.location.href='http://localhost:8080'
      })
    }
  },

  mounted() {
    var option = []
    for (var i in pca) {
      // let res = {}
      // console.log(i)
      if (i == '86') {
        for (var j in pca[i]) {
          // console.log(pca[i][j])
          let res = {}
          res['value'] = j
          res['label'] = pca[i][j]
          option.push(res)
        }
        // console.log(option)
        // console.log('---------------')
      } else {
        for (var k in option) {
          if (i == option[k].value) {
            let children = []
            for (var m in pca[i]) {
              let res2 = {}
              res2['value'] = m
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

    // for (var i in option) {
    //   console.log(option[i].value)
    // }
  },
  store
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
#about {
  height: 500px;
}
</style>
