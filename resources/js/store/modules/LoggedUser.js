const state = {
    User: {
      name: null,
      username: null,
      role: null,
    },
  
    isLoggedIn: false,
  };
  
  const mutations = {
    setLoggedUser (state, source) {
      state.User.name = source.name
      state.User.username = source.username
      state.User.role = source.role
      state.isLoggedIn = true
    },
  
    loggedOut (state) {
      state.isLoggedIn = false
    }
  }
  
  const getters = {
    name: state => state.User.name,
    role: state => state.User.role,
    username: state => state.User.username
  }
  
  export default {
    namespaced: true,
    state,
    mutations,
    getters
  };