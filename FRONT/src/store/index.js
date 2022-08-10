import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate';

export default createStore({
  state(){
    return {
      user: {},
      isLogin: false,
      itravel: null,
      feedIuser: null,
      filter: {},
      selectedArea: [],
      travel: {},
      travelDay: 0,
      unreadCnt: {},
      unreadCntAll: 0
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