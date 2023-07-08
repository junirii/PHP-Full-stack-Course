import { createStore } from 'vuex'; // 객체 내 function 하나 들고 오겠다
import createPersistedState from 'vuex-persistedstate';

export default createStore({
  state(){
    return {
      user: {},
      sellerSelectedProduct: {},
    }
  },
  mutations: {
    user: (state, data) => {
      state.user = data;
    },
    sellerSelectedProduct: (state, data) => {
      state.sellerSelectedProduct = data;
    }
  },
  plugins: [
    createPersistedState({
      paths: ['user']
    })
  ],
});