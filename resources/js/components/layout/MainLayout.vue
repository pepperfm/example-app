<template>
  <el-container>
    <router-view
      class="aside"
      name="aside"
    />
    <el-container class="flex-column">
      <router-view name="header" />
      <el-main style="height:100%">
        <router-view />
      </el-main>
    </el-container>
  </el-container>
</template>

<script>

export default {
  name: 'MainLayout',
  components: {},
}
</script>
