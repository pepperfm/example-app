import axios from '../../classes/AxiosWrapper'

const url = '/api/v1/user'

const state = {
  user: {
    name: '',
    email: ''
  },
}

const getters = {
  user: (state) => state.user,
}

const actions = {
  async getUser({ commit }) {
    const response = await axios.get(url)
    commit('SET_USER', response.data.user)
  },
}

const mutations = {
  SET_USER: (state, user) => {
    state.user = user
  },
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
}
