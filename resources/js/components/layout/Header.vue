<template>
  <el-header style="display: flex; height: 57px;">
    <nav class="main-header navbar d-flex align-items-center justify-content-between">
      <div
          @click="toggleCollapse()"
          @keydown="toggleCollapse()"
      >
        <em :class="['fas fa-bars',  { rotate: toggled }, 'burger']"></em>
      </div>
      <el-dropdown @command="handleCommand">
        <span class="currentUser">Admin</span>
        <template #dropdown>
          <el-dropdown-menu>
            <el-dropdown-item command="profile">Профиль</el-dropdown-item>
            <el-dropdown-item command="exit">Выход</el-dropdown-item>
          </el-dropdown-menu>
        </template>
      </el-dropdown>
    </nav>
  </el-header>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'DefaultHeader',
  data() {
    return {
      time: '',
      activeIndex: '1',
      pathName: 'Psych Manager',
      toggled: false,
      toggled2: true,
    }
  },

  computed: {
    ...mapGetters({}),
  },
  async mounted() {
    await this.getUser()
  },
  // async created() {
  //   this.$root.$on("set-path-name", (obj) => {
  //     this.pathName = obj.name;
  //     this.activeIndex = obj.activeIndex ? obj.activeIndex : "1";
  //     if (obj.active) {
  //       this.activeIndex = "active";
  //     }
  //   });
  // },
  methods: {
    ...mapActions({}),

    toggleCollapse() {
      this.toggled = !this.toggled
      this.collapse()
    },
    async exit() {
      localStorage.setItem('accessToken', '')
      await this.$identity.deauth()
      await this.$router.replace({ name: 'login' })
    },
    async handleCommand(command) {
      if (command === 'profile') {
        await this.$router.push({ name: command })
      }
      if (command === 'exit') {
        await this.exit()
      }
    },
  },
}
</script>

<style lang="css" scoped>
.main-header {
  width: 100%;
}
.rotate {
  transform: rotate(270deg);
}

.burger {
  transition: all 300ms ease-in-out;
  font-size: 20px !important;
  color: rgba(0, 0, 0, 0.5);
}

.burger:hover {
  color: rgba(0, 0, 0, 0.7);
}

.el-dropdown-link {
  width: 100%;
}

.logo {
  width: 220px;
  text-align: center;
}

.el-menu--horizontal > .el-menu-item.is-active {
  border: 0;
}

.el-menu-demo li {
  padding: 0 10px;
}
</style>
