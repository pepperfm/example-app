<template>
  <div class="login">
    <el-card class="text-center">
      <img
        src="../../../../public/favicon.ico"
        alt="LOGO"
      >
      <h2>Example App</h2>
      <el-form
        ref="loginForm"
        class="login-form"
        :model="loginForm"
        :rules="rules"
        @submit.prevent="auth()"
      >
        <el-form-item prop="username">
          <el-input
            v-model="loginForm.username"
            placeholder="Email"
            prefix-icon="Link"
          ></el-input>
        </el-form-item>
        <el-form-item prop="password">
          <el-input
            v-model="loginForm.password"
            placeholder="Пароль"
            type="password"
            prefix-icon="Lock"
          ></el-input>
        </el-form-item>
        <el-form-item>
          <el-button
            v-loading.fullscreen.lock="loading"
            class="login-button"
            native-type="submit"
            type="primary"
          >Войти
          </el-button>
        </el-form-item>
      </el-form>
    </el-card>
  </div>
</template>

<script>
export default {
  name: 'MainLogin',
  data() {
    const validatePass = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('Please input the password'))
      } else if (value.length < 6) {
        callback(new Error('Password length should more then 5 characters'))
      } else {
        callback()
      }
    }
    return {
      actions: {
        auth: '/api/v1/login',
      },
      loginForm: {
        username: '',
        password: '',
        grant_type: 'password',
      },
      loading: false,
      rules: {
        username: [
          { type: 'email', trigger: 'submit', required: true },
        ],
        password: [
          { validator: validatePass, trigger: 'submit' },
        ],
      },
    }
  },
  methods: {
    async auth() {
      await this.$refs.loginForm.validate((valid) => {
        if (valid) {
          this.identityLogin()
        } else {
          this.$message.error('Неправильные данные')
        }
      })
    },
    async identityLogin() {
      this.loading = true
      try {
        const response = await this.$http.post(this.actions.auth, this.loginForm)
        localStorage.setItem('accessToken', response.data.access_token)
        window.$identity.isGuest = false
        const redirect = await this.$route.query.redirect ? this.$route.query.redirect : '/'
        await this.$router.push(redirect)
        this.$message.success('Success')
        this.loading = false
      } catch (e) {
        if (!e.response) {
          throw e
        }
        switch (e.response.status) {
          case 422:
            this.$message.error(e.response.data.message)
            break
          default:
            this.$message.error(e.response.data.message)
        }
      }
    },
    resetForm() {
      this.$refs.loginForm.resetFields()
    },
  },
}

</script>
<style lang="scss" scoped>
.login {
  height: 100vh;
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
}

.login .el-input__prefix {
  height: calc(100% - 2px);
  border-radius: 3px;
  .el-input__icon {
    width: 30px;
  }
}
.login-button {
  width: 100%;
  margin-top: 20px;
}

h2 {
  letter-spacing: 1px;
  padding-top: 10px;
  padding-bottom: 20px;
}

.login-form {
  width: 290px;
}
.login .el-card {
  width: 340px;
  display: flex;
  justify-content: center;
}
.el-input__wrapper {
  padding: 1px 1px!important;
}

</style>
