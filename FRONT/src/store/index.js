import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate';

export default createStore({
  state(){
    return {
      user: {},
      isLogin: false
    }
  },
  mutations: {
    user: (state, data) => {
      state.user = data;
    },
  },
  plugins: [
    createPersistedState({
      paths: ['user']
    })
  ],
});