export default createStore({
  state(){
    return {
      user: {},
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