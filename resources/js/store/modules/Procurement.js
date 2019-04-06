import procurementService from '../../service/Procurement'

const state = {
  procurements: [],
  procurement: {
    id_procurement: '',
    procurement_status: '',
    date: '',
    id_sales: '',
    sales: '',
    detail: [],
  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.procurements = payload
    state.loading = false
    state.error = null
  },

  setFailedAction(state, payload) {
    state.loading = false
    state.error = payload.error
  },

  resetProcurementForm(state) {
    state.procurement.procurement_status = ""
    state.procurement.id_sales = ""
    state.procurement.date = ""
    state.procurement.detail = []
  },

  setProcurementForm(state, payload) {
    state.procurement.procurement_status = payload.procurement_status
    state.procurement.id_sales = payload.id_sales
    state.procurement.date = payload.date
    state.procurement.detail = payload.detail.data
  }
}

const getters = {
  error: state => state.error,
  loading: state => state.loading,
  procurement: state => state.procurement
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await procurementService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async findBySupplier(context,id) {
    try {
      context.commit('setSource', await procurementService.findBySupplier(id))
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await procurementService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      const res = await procurementService.find(id)
      context.commit('setProcurementForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      const data = {
        procurement_status: payload.procurement_status,
        id_supplier: payload.id_supplier,
        procurement_phone_number: payload.procurement_phone_number
      }

      await procurementService.update(payload.id_procurement, data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await procurementService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('resetProcurementForm')
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}