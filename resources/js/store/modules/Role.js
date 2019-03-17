import roleService from '../../service/Role'

const state = {
    roles: [],
    role: {
        id_role: '',
        role_name: ''
    },
    loading: false,
    error: false,
  }
  
const mutations = {
setSource (state, payload) {
    state.roles = payload
    state.loading = false
    state.error = null
},

setFailedAction(state, payload) {
    state.loading = false
    state.error = payload.error
},

setRoleForm(state, payload) {
    state.role.role_name = payload.role_name
}
}

const getters = {
    error: state => state.error,
    loading: state => state.loading,
    roles: state => state.role
}

const actions = {
    async get(context) {
        try {
        context.commit('setSource', await roleService.get())
        } catch (err) {
        context.commit('setFailedAction', err)
        }
    },
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}