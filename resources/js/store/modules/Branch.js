import branchService from '../../service/Branch'

const state = {
  branches: [],
  branch: {
    branch_name: '',
    branch_address: '',
    branch_phone_number: '',
  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.branches = payload
    state.loading = false
    state.error = null
  },

  setFailedAction(state, payload) {
    state.loading = false
    state.error = payload.error
  },

  setBranchForm(state, payload) {
    state.branch.branch_name = payload.branch_name
    state.branch.branch_address = payload.branch_address
    state.branch.branch_phone_number = payload.branch_phone_number
  }
}

const getters = {
  error: state => state.error,
  loading: state => state.loading,
  branch: state => state.branch
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await branchService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await branchService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      const res = await branchService.find(id)
      context.commit('setBranchForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      const data = {
        branch_name: payload.branch_name,
        branch_address: payload.branch_address,
        branch_phone_number: payload.branch_phone_number
      }

      await branchService.update(payload.id_branch, data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await branchService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('setBranchForm', {})
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}