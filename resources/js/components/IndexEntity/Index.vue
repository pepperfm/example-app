<template>
  <el-row :gutter="24">
    <el-col :span="24">
      <el-table
        :data="entities"
        border
        row-key="id"
        style="width: 100%"
      >
        <el-table-column
          prop="id"
          label="ID"
          width="180"
        />
        <el-table-column
          prop="user.name"
          label="User name"
          width="500"
        />
        <el-table-column
          fixed="right"
          label="Operations"
          width="300"
        >
          <template #default="scope">
            <el-button
              size="small"
              type="primary"
              plain
              @click="showModal(scope.row)"
            >
              Show
            </el-button>
            <el-button
              size="small"
              type="warning"
              @click="handleEdit(scope.$index, scope.row)"
            >
              Edit
            </el-button>
            <el-button
              size="small"
              type="danger"
              @click="handleDelete(scope.$index, scope.row)"
            >
              Delete
            </el-button>
          </template>
        </el-table-column>
      </el-table>

      <el-dialog
        v-model="dialogFormVisible"
        :title="`Entity id ${form.entity_id} details`"
      >
        <el-form
          ref="loginForm"
          :model="form"
          label-position="left"
          label-width="200px"
        >
          <el-form-item
            prop="data"
            label="Json"
          >
            <el-input
              v-model="form.data"
              :rows="10"
              clearable
              resize="vertical"
              readonly
              type="textarea"
              placeholder="Json data"
              @change="toJson"
            >
              <el-tree
                :data="tree"
                :props="defaultProps"
                @node-click="handleNodeClick"
              />
            </el-input>
          </el-form-item>
        </el-form>
        <template #footer>
          <span class="dialog-footer">
            <el-button @click="closeModal">Cancel</el-button>
          </span>
        </template>
      </el-dialog>
    </el-col>
  </el-row>
</template>

<script>
export default {
  name: "EntityIndexTable",
  data() {
    return {
      actions: {
        rest: '/api/v1/entities',
      },
      form: {
        data: '',
        entity_id: '',
      },
      entities: [],
      dialogFormVisible: false,
      defaultProps: {
        children: 'children',
        label: 'label',
      },
      tree: [],
    }
  },
  async created() {
    let response = await this.$http.get(this.actions.rest)
    this.entities = response.data.entities
  },
  methods: {
    async showModal(row) {
      let response = await this.$http.get(`${this.actions.rest}/${row.id}/tree`)
      this.tree = response.data.tree
      this.form = row
      this.form.data = JSON.stringify(row.data, undefined, 4)
      this.dialogFormVisible = true
    },
    closeModal() {
      this.form.data = JSON.parse(this.form.data)
      this.dialogFormVisible = false
    },
    handleEdit() {

    },
    handleDelete() {

    },
    onSubmit() {

    },
    handleNodeClick() {

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
