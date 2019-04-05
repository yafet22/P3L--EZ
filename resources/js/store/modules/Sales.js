import salesService from '../../service/Sales'

const state = {
  salesmany: [],
  sales: {
    sales_name: '',
    id_supplier: '',
    sales_phone_number: '',
  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.salesmany = payload
    state.loading = false
    state.error = null
  },

  setFailedAction(state, payload) {
    state.loading = false
    state.error = payload.error
  },

  setSalesForm(state, payload) {
    state.sales.sales_name = payload.sales_name
    state.sales.id_supplier = payload.id_supplier
    state.sales.sales_phone_number = payload.sales_phone_number
  }
}

const getters = {
  error: state => state.error,
  loading: state => state.loading,
  sales: state => state.sales
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await salesService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async findBySupplier(context,id) {
    try {
      context.commit('setSource', await salesService.findBySupplier(id))
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await salesService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      const res = await salesService.find(id)
      context.commit('setSalesForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      const data = {
        sales_name: payload.sales_name,
        id_supplier: payload.id_supplier,
        sales_phone_number: payload.sales_phone_number
      }

      await salesService.update(payload.id_sales, data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await salesService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('setSalesForm', {})
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}