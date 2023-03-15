<template>
  <el-row :gutter="24">
    <el-col :span="10">
      <el-form
        :model="form"
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
        <el-form-item>
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
    return {
      actions: {

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
    onSubmit() {
      let response
      if (this.form.method === 'get') {
        response = this.$http.get()
      }
      if (this.form.method === 'post') {
        response = this.$http.post()
      }
    },
    toJson(value) {
      console.log(value)
      let parsed= JSON.parse(this.form.data);
      this.form.data = JSON.stringify(parsed, undefined, 4);
    },
  },
}
</script>

<style scoped>

</style>
