import reportService from '../../service/Report'

const state = {
  reports: [],
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.reports = payload
    state.loading = false
    state.error = null
  },

  setFailedAction(state, payload) {
    state.loading = false
    state.error = payload.error
  },

  setReportForm(state, payload) {
    state.reports =payload
  }

}

const getters = {
  error: state => state.error,
  loading: state => state.loading,
}

const actions = {

  async transactionperYear(context, id) {
    try {
      const res = await reportService.transactionperYear(id)
      context.commit('setReportForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async printTransactionperMonth(context, id) {
    try {
      await reportService.printTransactionperMonth(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}