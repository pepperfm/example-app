<template>
  <div>
    <div class="container-fluid">
      <h1>Панель управления</h1>
    </div>
    <div class="content">
      <p>Добро пожаловать</p>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'MainPage',
  computed: {
    ...mapGetters({}),
  },
  async created() {
  },
  methods: {
    ...mapActions({}),
  },
}
</script>

<style scoped>

</style>
