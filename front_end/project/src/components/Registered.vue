<template>
  <div id="registered">
    <!-- <h1>{{ msg }}</h1> -->
    <!-- 布局 -->
    <el-row type="flex" class="row-bg" justify="center">
      <el-col :span="10">
        <el-card class="box-card">
          <div slot="header" style="text-align: left;">
            <span>注 册</span>

            <router-link to="/login">
              <el-button style="float: right; padding: 3px 0" type="text">登录</el-button>
            </router-link>
            <span style="float: right">已有账号？</span>
          </div>
          <el-form :model="ruleForm" status-icon :rules="rules2" ref="ruleForm" label-width="100px" class="demo-ruleForm">
            <!-- age -->
            <!-- <el-form-item label="age" prop="age">
              <el-input v-model.number="ruleForm.age"></el-input>
            </el-form-item> -->
            <!-- email -->
            <el-form-item prop="email" label="邮箱" :rules="[
                      { required: true, message: '请输入邮箱地址', trigger: 'blur' },
                      { type: 'email', message: '请输入正确的邮箱地址', trigger: ['blur', 'change'] }]">
              <el-input v-model="ruleForm.email"></el-input>
            </el-form-item>
            <el-form-item label="密码" prop="pass">
              <el-input type="password" v-model="ruleForm.pass" auto-complete="off"></el-input>
            </el-form-item>
            <el-form-item label="确认密码" prop="checkPass">
              <el-input type="password" v-model="ruleForm.checkPass" auto-complete="off"></el-input>
            </el-form-item>

            <el-form-item>
              <el-button type="primary" @click="submitForm('ruleForm')">注册</el-button>
              <el-button @click="resetForm('ruleForm')">重置</el-button>
            </el-form-item>
          </el-form>
        </el-card>
        <!-- <div>{{show}}</div> -->
      </el-col>
    </el-row>

  </div>
</template>

<script>
import axios from 'axios'
export default {
  data() {
    var validatePass = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('请输入密码'))
      } else {
        if (this.ruleForm.checkPass !== '') {
          this.$refs.ruleForm.validateField('checkPass')
        }
        callback()
      }
    }
    var validatePass2 = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('请再次输入密码'))
      } else if (value !== this.ruleForm.pass) {
        callback(new Error('两次输入密码不一致!'))
      } else {
        callback()
      }
    }
    // var validateNickName = (rule, value, callback) => {
    //   if (value === ''){
    //     callback(new Error('请填写昵称'))
    //   }
    // }
    return {
      ruleForm: {
        email: '',
        pass: '',
        checkPass: ''
        // nickName: ''

        // age: ''
      },
      rules2: {
        pass: [{ required: true, validator: validatePass, trigger: 'blur' }],
        checkPass: [
          { required: true, validator: validatePass2, trigger: 'blur' }
        ]

        // age: [{ validator: checkAge, trigger: 'blur' }]
      }
    }
  },
  computed: {
    show() {
      return this.ruleForm
    }
  },
  methods: {
    submitForm(formName) {
      this.$refs[formName].validate(valid => {
        if (valid) {
          // for (var i in this.show) {
          //   console.log(i)
          //   console.log(this.show[i])
          // }
          // console.log(this.show['email'])
          let that = this
          // var params = new URLSearchParams()
          // params.append('email', this.show['email'])
          // params.append('password', this.show['password'])
          // params.append('password_confirm', this.show['password_confirm'])
          axios({
            method: 'post',
            url: 'http://localhost:8089/gd/back_end/public/index.php/v1/user',
            data: {
              email: that.show['email'],
              password: that.show['pass'],
              password_confirm: that.show['checkPass']
            },
            // data: params,
            withCredentials: true
          }).then(function(response) {
            // alert('注册成功！')
            that.$message({
              showClose: true,
              message: '注册成功！',
              type: 'success'
            })
            window.location.href = 'http://localhost:8080/#/login'
          }).catch(function(error){
            that.$message({
              showClose: true,
              message: error.response.data.message,
              type: 'error'
            })
          })
          // alert('submit!')
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
#registered {
  height: 500px;
}
.demo-ruleForm {
  margin: 20px 20px 0 0;
  padding: 20px 20px 0 0;
  /* border: 1px solid; */
}
</style>
