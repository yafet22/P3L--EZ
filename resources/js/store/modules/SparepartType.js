import sparepartTypeService from '../../service/SparepartType'

const state = {
  sparepartTypes: [],
  sparepartType: {
    id_sparepart_type: '',  
    sparepart_type_name: '',
  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.sparepartTypes = payload
    state.loading = false
    state.error = null
  },

  setFailedAction(state, payload) {
    state.loading = false
    state.error = payload.error
  },

  setSparepartTypeForm(state, payload) {
    state.sparepartType.id_sparepart_type = payload.id_sparepart_type
    state.sparepartType.sparepart_type_name = payload.sparepart_type_name
  }
}

const getters = {
  error: state => state.error,
  loading: state => state.loading,
  sparepartType: state => state.sparepartType
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await sparepartTypeService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await sparepartTypeService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      const res = await sparepartTypeService.find(id)
      context.commit('setSparepartTypeForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      const data = {
        sparepart_type_name: payload.sparepart_type_name,
      }

      await sparepartTypeService.update(payload.id_sparepart_type, data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await sparepartTypeService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('setSparepartTypeForm', {})
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}