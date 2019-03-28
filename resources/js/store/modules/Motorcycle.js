import motorcycleService from '../../service/Motorcycle'

const state = {
  motorcycles: [],
  motorcycle: {
    license_number: '',
    id_motorcycle_type: '',
    id_motorcycle_brand: '',
    id_customer: '',
  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.motorcycles = payload
    state.loading = false
    state.error = null
  },

  setFailedAction(state, payload) {
    state.loading = false
    state.error = payload.error
  },

  setMotorcycleForm(state, payload) {
    state.motorcycle.license_number = payload.license_number
    state.motorcycle.id_motorcycle_type = payload.id_motorcycle_type
    state.motorcycle.id_motorcycle_brand = payload.id_motorcycle_brand
    state.motorcycle.id_customer = payload.id_customer
  }
}

const getters = {
  error: state => state.error,
  loading: state => state.loading,
  motorcycle: state => state.motorcycle
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await motorcycleService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async findByUser(context,id) {
    try {
      context.commit('setSource', await motorcycleService.findByUser(id))
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await motorcycleService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      const res = await motorcycleService.find(id)
      context.commit('setMotorcycleForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      const data = {
        license_number: payload.license_number,
        id_motorcycle_type: payload.id_motorcycle_type,
        id_customer: payload.id_customer
      }

      await motorcycleService.update(payload.id_motorcycle, data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await motorcycleService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('setMotorcycleForm', {})
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}