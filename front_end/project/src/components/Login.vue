<template>
  <div id="login">
    <!-- <h1>{{ msg }}</h1> -->
    <el-row type="flex" class="row-bg" justify="center">
      <el-col :span="10">
        <el-card class="box-card">
          <div slot="header" class="test">
            <span>登 录</span>

            <router-link to="/registered">
              <el-button style="float: right; padding: 3px 0" type="text">注册</el-button>
            </router-link>
            <span style="float:right;">未有账号？</span>

          </div>

          <el-form :model="ruleLogin" status-icon :rules="rulesLogin" ref="ruleLogin" label-width="100px" class="login-form">
            <el-form-item prop="email" label="邮箱" :rules="[
                      { required: true, message: '请输入邮箱地址', trigger: 'blur' },
                      { type: 'email', message: '请输入正确的邮箱地址', trigger: ['blur', 'change'] }]">
              <el-input v-model="ruleLogin.email"></el-input>

            </el-form-item>
            <el-form-item label="密码" prop="pass">
              <el-input type="password" v-model="ruleLogin.pass" auto-complete="off"></el-input>
            </el-form-item>
            <el-form-item>
              <el-button type="primary" @click="submitForm('ruleLogin')">登录</el-button>
              <el-button @click="resetForm('ruleLogin')">重置</el-button>
            </el-form-item>
          </el-form>

        </el-card>
      </el-col>
    </el-row>

  </div>
</template>

<script>
import axios from 'axios'
axios.defaults.withCredentials = true
export default {
  data() {
    var validatePass = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('请输入密码'))
      } else {
        // if (this.ruleLogin.checkPass !== '') {
        //   this.$refs.ruleLogin.validateField('checkPass')
        // }
        callback()
      }
    }
    return {
      ruleLogin: {
        email: '',
        pass: ''
      },
      msg: 'Welcome to Your Vue.js App',
      rulesLogin: {
        pass: [{ required: true, validator: validatePass, trigger: 'blur' }]
      }
    }
  },
  methods: {
    submitForm(formName) {
      this.$refs[formName].validate(valid => {
        const querystring = require('querystring')
        if (valid) {
          // this.ruleLogin
          // axios
          //   .post(
          //     this.GLOBAL.apiurl+'auth',
          //     querystring.stringify({
          //       email: this.ruleLogin.email,
          //       password: this.ruleLogin.pass
          //     })
          //   )
          let that = this
          axios({
            method: 'post',
            url: this.GLOBAL.apiurl+'auth',
            data: {
              email: that.ruleLogin.email,
              password: that.ruleLogin.pass
            },
            withCredentials: true
          })
            .then(function(response) {
              
              that.$message({
                showClose: true,
                message: '登录成功！',
                type: 'success'
              })
              // console.log(response.data)
              // alert('登录成功！')
              
              window.location.href = 'http://localhost:8080/'
              // console.log(response)
            })
            .catch(function(error) {
              // console.log(error.response.data.message)
              // alert(response.data.message)
              that.$message({
                showClose: true,
                message: error.response.data.message,
                type: 'error'
              })
              
            })
          // alert(response)
        } else {
          console.log('error submit!!')
          return false
        }
      })
    },
    resetForm(formName) {
      this.$refs[formName].resetFields()
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
#login {
  height: 360px;
}
.test {
  text-align: left;
}
.login-form {
  margin: 20px 20px 0 0;
  padding: 20px 20px 0 0;
}
</style>
