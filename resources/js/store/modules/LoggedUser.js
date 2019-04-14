const state = {
    User: {
      id: null,
      name: null,
      username: null,
      role: null,
    },
  
    isLoggedIn: false,
  };
  
  const mutations = {
    setLoggedUser (state, source) {
      state.User.id = source.id
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
    id: state => state.User.id,
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