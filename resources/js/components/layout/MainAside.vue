<template>
  <el-aside
    id="sidebar"
    style="height: 100%"
    :style="{ width: $store.state.asideState.collapsed ? '80px' : '250px' }"
  >
    <el-scrollbar
      class="h-100"
      :style="{ width: $store.state.asideState.collapsed ? '90px' : '250px' }"
    >
      <el-menu
        class="d-flex flex-column justify-content-between"
        :default-active="$route.meta.menuitem"
        :collapse="$store.state.asideState.collapsed"
        style="border: none; height:100vh"
        background-color="#343a40"
        text-color="#cfd8dc"
        active-text-color="#ffffff"
      >
        <div>
          <el-menu-item
            class="main-nav-logo"
            @click="toRoute('main')"
          >
            <svg
              id="Layer_1"
              width="40"
              height="40"
              version="1.1"
              xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink"
              x="0px"
              y="0px"
              viewBox="0 0 512 512"
              style="enable-background:new 0 0 512 512;"
              xml:space="preserve"
            >
              <circle
                style="fill:#E6F3FF;"
                cx="256"
                cy="256"
                r="256"
              />
              <path
                style="fill:#CFDBE6;"
                d="M509.211,293.84L407.604,192.233l-25.255,59.801l-99.981-99.981l-82.76,108.349l-95.997,90.172
                    l161.258,161.258C389.392,507.589,491.344,414.427,509.211,293.84z"
              />
              <path
                style="fill:#A03D50;"
                d="M337.594,265.388c-41.753,0-78.419,21.688-99.416,54.396c20.999,32.706,57.663,54.396,99.416,54.396
                    s78.419-21.688,99.416-54.396C416.011,287.079,379.347,265.388,337.594,265.388z"
              />
              <path
                style="fill:#C75163;"
                d="M174.406,265.388c41.753,0,78.419,21.688,99.416,54.396c-20.999,32.706-57.663,54.396-99.416,54.396
                    s-78.419-21.688-99.416-54.396C95.989,287.079,132.653,265.388,174.406,265.388z"
              />
              <path
                style="fill:#FF6472;"
                d="M290.404,226.513c-31.815,31.808-43.225,76.266-34.304,117.186
                    c40.922,8.928,85.385-2.474,117.2-34.28s43.225-76.266,34.304-117.186C366.682,183.303,322.219,194.705,290.404,226.513z"
              />
              <path
                style="fill:#FF80AA;"
                d="M221.596,226.513c31.815,31.808,43.225,76.266,34.304,117.186
                    c-40.922,8.928-85.385-2.474-117.2-34.28s-43.225-76.266-34.304-117.186C145.318,183.303,189.781,194.705,221.596,226.513z"
              />
              <path
                style="fill:#FF6472;"
                d="M197.387,236.654c0,44.991,23.371,84.497,58.613,107.124c35.242-22.626,58.613-62.133,58.613-107.124
                    S291.242,152.157,256,129.531C220.758,152.157,197.387,191.664,197.387,236.654z"
              />
              <path
                style="fill:#C75163;"
                d="M314.613,236.654c0-44.99-23.371-84.497-58.613-107.124v214.245
                    C291.242,321.152,314.613,281.645,314.613,236.654z"
              />
            </svg>
            <!--<img width="40px" height="40px" :src="require('../../
          ../../public/img/logo.png').default" alt="logo"/>-->
            <span class="el-menu-title">Example App</span>
          </el-menu-item>

          <el-menu-item
            index="1"
            @click="toRoute('store-entity')"
          >
            <em class="fas fa-address-card" />
            <span
              v-if="!$store.state.asideState.collapsed"
              class="el-menu-title"
            >Command 1</span>
          </el-menu-item>

          <el-menu-item
            index="2"
            @click="toRoute('show-entity')"
          >
            <em class="fas fa-comments" />
            <span
              v-if="!$store.state.asideState.collapsed"
              class="el-menu-title"
            >Command 2</span>
          </el-menu-item>

          <el-menu-item
            index="3"
            @click="toRoute('index')"
          >
            <em class="fas fa-comments" />
            <span
              v-if="!$store.state.asideState.collapsed"
              class="el-menu-title"
            >Table</span>
          </el-menu-item>
        </div>
      </el-menu>
    </el-scrollbar>
  </el-aside>
</template>
<script>

export default {
  methods: {
    toRoute(alias) {
      this.$router.push({ name: alias })
    },
  },
}
</script>
<style lang="css" scoped>

.fs-7 {
  font-size: 0.75rem!important;;
}

.el-menu-title {
  margin-left: 5px;
}

.el-scrollbar, el-aside {
  background-color: #343a40 ;
  width: 100%;
}

.el-scrollbar, el-aside {
  z-index: 9;
  transition: width 300ms ease-in-out;
}

.el-menu {
  width: 250px;
}

.el-menu--collapse {
  width: 80px;
}

.el-menu-vertical {
  border: 0;
}

.el-menu-item.is-active:not(.main-nav-logo) {
  background-color: #007bff !important;
  border-radius: 0.25rem;
}

.el-menu-item {
  height: 45px;
  line-height: 45px;
}

.el-menu-item:not(.is-active, .main-nav-logo):hover {
  background-color: rgba(255, 255, 255, 0.1) !important;
  border-radius: 0.25rem;
}

.el-menu-item {
  margin: 0.3rem 0.5rem;
}

.main-nav-logo {
  height: 57px;
  margin: 0;
  background-color: #343a40 !important;
}

.main-nav-logo:hover, .main-nav-logo:active, .main-nav-logo:focus, .main-nav-logo:visited {
  background-color: #343a40 !important;
}

</style>
