const state = {
    users: [],
    loading: false,
    error: false
  }
  
  const mutations = {
    setSource (state, payload) {
      state.users = payload
    }
  }
  
  const getters = {
    users: state => state.users
  }
  
  export default {
    namespaced: true,
    state,
    mutations,
    getters
  }