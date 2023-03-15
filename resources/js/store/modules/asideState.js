const state = {
  collapsed: false,
}

const getters = {
  collapsed: (state) => state.collapsed,
}

const actions = {
  collapse({ commit }) {
    commit('setCollapse', !state.collapsed)
  },
}

const mutations = {
  setCollapse: (state, collapsed) => {
    state.collapsed = collapsed
  },
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
}
