import serviceService from '../../service/Service'

const state = {
  services: [],
  service: {
    service_name: '',
    price: '',
  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.services = payload
    state.loading = false
    state.error = null
  },

  setFailedAction(state, payload) {
    state.loading = false
    state.error = payload.error
  },

  setServiceForm(state, payload) {
    state.service.service_name = payload.service_name
    state.service.price = payload.price
  }
}

const getters = {
  error: state => state.error,
  loading: state => state.loading,
  service: state => state.service
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await serviceService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await serviceService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      const res = await serviceService.find(id)
      context.commit('setServiceForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      const data = {
        service_name: payload.service_name,
        price: payload.price,
      }

      await serviceService.update(payload.id_service, data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await serviceService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('setServiceForm', {})
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}