import motorcycleBrandService from '../../service/MotorcycleBrand'

const state = {
  motorcycleBrands: [],
  motorcycleBrand: {
    motorcycle_brand_name: '',
  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.motorcycleBrands = payload
    state.loading = false
    state.error = null
  },

  setFailedAction(state, payload) {
    state.loading = false
    state.error = payload.error
  },

  setMotorcycleBrandForm(state, payload) {
    state.motorcycleBrand.motorcycle_brand_name = payload.motorcycle_brand_name
  }
}

const getters = {
  error: state => state.error,
  loading: state => state.loading,
  motorcycleBrand: state => state.motorcycleBrand
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await motorcycleBrandService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await motorcycleBrandService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      const res = await motorcycleBrandService.find(id)
      context.commit('setMotorcycleBrandForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      const data = {
        motorcycle_brand_name: payload.motorcycle_brand_name
      }

      await motorcycleBrandService.update(payload.id_motorcycle_brand, data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await motorcycleBrandService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('setMotorcycleBrandForm', {})
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}