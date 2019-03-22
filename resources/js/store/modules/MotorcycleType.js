import motorcycleTypeService from '../../service/MotorcycleType'

const state = {
  motorcycleTypes: [],
  motorcycleType: {
    motorcycle_type_name: '',
    id_motorcycle_brand: ''
  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.motorcycleTypes = payload
    state.loading = false
    state.error = null
  },

  setFailedAction(state, payload) {
    state.loading = false
    state.error = payload.error
  },

  setMotorcycleTypeForm(state, payload) {
    state.motorcycleType.motorcycle_type_name = payload.motorcycle_type_name,
    state.motorcycleType.id_motorcycle_brand = payload.id_motorcycle_brand
  }
}

const getters = {
  error: state => state.error,
  loading: state => state.loading,
  motorcycleType: state => state.motorcycleType
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await motorcycleTypeService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await motorcycleTypeService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      const res = await motorcycleTypeService.find(id)
      context.commit('setMotorcycleTypeForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      const data = {
        motorcycle_type_name: payload.motorcycle_type_name,
        id_motorcycle_brand: payload.id_motorcycle_brand
      }

      await motorcycleTypeService.update(payload.id_motorcycle_type, data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await motorcycleTypeService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('setMotorcycleTypeForm', {})
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}