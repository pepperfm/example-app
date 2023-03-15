<template>
  <el-row :gutter="24">
    <el-col :span="10">
      <el-form
        ref="loginForm"
        :model="form"
        :rules="rules"
        label-position="left"
        label-width="120px"
      >
        <el-form-item label="Token">
          <el-input
            v-model="form.token"
            clearable
          />
        </el-form-item>
        <el-form-item label="Request method">
          <el-select
            v-model="form.method"
            class="m-2 w-100"
            clearable
            placeholder="Select request method"
          >
            <el-option
              v-for="item in request_types_options"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>
        <el-form-item prop="data">
          <el-input
            v-model="form.data"
            :rows="10"
            clearable
            resize="vertical"
            type="textarea"
            placeholder="Json data"
            @change="toJson"
          />
        </el-form-item>
        <el-form-item>
          <el-button
            type="primary"
            @click="onSubmit"
          >
            Create
          </el-button>
        </el-form-item>
      </el-form>
    </el-col>
    <el-col :span="14" />
  </el-row>
</template>

<script>
export default {
  name: "StoreDataForm",
  data() {
    const validatePass = (rule, value, callback) => {
      if (value.length >= 1024) {
        callback(new Error('Data is too long'))
      } else {
        callback()
      }
    }
    return {
      rules: {
        data: [
          { validator: validatePass, trigger: 'submit' },
        ],
      },
      actions: {
        rest: '/api/v1/store-data'
      },
      form: {
        token: '',
        method: '',
        data: '',
      },
      request_types_options: [
        { label: 'GET', value: 'get' },
        { label: 'POST', value: 'post' },
      ]
    }
  },
  methods: {
    async onSubmit() {
      let response
      await this.$refs.loginForm.validate((valid) => {
        if (valid) {
          if (this.form.method === 'get') {
            response = this.$http.get(this.actions.rest, {
                headers: {
                    Authorisation: `Bearer ${this.form.token}`
                },
                params: { data: this.form.data },
            })
          }
          if (this.form.method === 'post') {
            response = this.$http.post(this.actions.rest, { data: JSON.parse(this.form.data) }, {
                headers: {
                    Authorisation: `Bearer ${this.form.token}`
                }
            })
          }
        } else {
          this.$message.error('Data is too long')
        }
      })
    },
    toJson(value) {
      let parsed = JSON.parse(value)
      this.form.data = JSON.stringify(parsed, undefined, 4)
    },
  },
}
</script>

<style scoped>

</style>
