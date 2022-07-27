import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate';

export default createStore({
  state(){
    return {
      user: {}, // 로그인한 유저정보가 담겨있음
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