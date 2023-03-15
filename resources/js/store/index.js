import { createStore } from 'vuex'

import asideState from '@modules/asideState'
import user from '@modules/user'

const store = createStore({
  modules: {
    asideState,
    user
  },
})

export default store
