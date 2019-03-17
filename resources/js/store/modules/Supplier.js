import supplierService from '../../service/Supplier'

const state = {
  suppliers: [],
  supplier: {
    supplier_name: '',
    supplier_address: '',
    supplier_phone_number: '',
  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.suppliers = payload
    state.loading = false
    state.error = null
  },

  setFailedAction(state, payload) {
    state.loading = false
    state.error = payload.error
  },

  setSupplierForm(state, payload) {
    state.supplier.name = payload.supplier_name
    state.supplier.address = payload.supplier_address
    state.supplier.phone_number = payload.supplier_phone_number
  }
}

const getters = {
  error: state => state.error,
  loading: state => state.loading,
  supplier: state => state.supplier
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await supplierService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await supplierService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      const res = await supplierService.find(id)
      context.commit('setSupplierForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      const data = {
        supplier_name: payload.supplier_name,
        supplier_address: payload.supplier_address,
        supplier_phone_number: payload.supplier_phone_number
      }

      await supplierService.update(payload.id_supplier, data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await supplierService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('setSupplierForm', {})
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}