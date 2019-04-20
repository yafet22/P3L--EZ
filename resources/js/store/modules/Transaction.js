import transactionService from '../../service/Transaction'

const state = {
  transactions: [],
  transaction: {
    id_transaction: '',
    transaction_status: 'unprocessed',
    transaction_paid: '',
    transaction_type: '',
    transaction_date: '',
    transaction_discount: '',
    transaction_total: '',
    id_customer: '',
    id_service: '',
    id_employee: '',
    service: [],
    sparepart: []
  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.transactions = payload
    state.loading = false
    state.error = null
  },

  setFailedAction(state, payload) {
    state.loading = false
    state.error = payload.error
  },

  resetTransactionForm(state) {
    state.transaction.id_transaction = ''
    state.transaction.transaction_status = "Unprocessed"
    state.transaction.transaction_paid= '',
    state.transaction.transaction_type= '',
    state.transaction.transaction_discount= '',
    state.transaction.transaction_total= '',
    state.transaction.transaction_date='',
    state.transaction.id_customer= '',
    state.transaction.service= [],
    state.transaction.sparepart= []
  },

  setTransactionForm(state, payload) {
    var name = payload.transaction_date;
    var word = name.split(' ');
    state.transaction.id_transaction = payload.id_transaction
    state.transaction.transaction_status = payload.transaction_status
    state.transaction.transaction_paid = payload.transaction_paid
    state.transaction.transaction_type = payload.transaction_type
    state.transaction.transaction_discount = payload.transaction_discount
    state.transaction.transaction_total = payload.transaction_total
    state.transaction.transaction_date = word[0]
    state.transaction.id_customer = payload.id_customer
    state.transaction.service = payload.service.data
    state.transaction.sparepart = payload.sparepart.data
  }
}

const getters = {
  error: state => state.error,
  loading: state => state.loading,
  transaction: state => state.transaction
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await transactionService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await transactionService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      const res = await transactionService.find(id)
      context.commit('setTransactionForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      const data = {
        transaction_status: payload.transaction_status,
        id_customer: payload.id_customer,
        transaction_type: payload.transaction_type,
        transaction_total: payload.transaction_total,
        service: payload.service,
        sparepart: payload.sparepart
      }

      await transactionService.update(payload.id_transaction, data)
      state.loading = false
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await transactionService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('resetTransactionForm')
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}