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

  async expenseperYear(context, id) {
    try {
      const res = await reportService.expenseperYear(id)
      context.commit('setReportForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async transactionByBranch(context) {
    try {
      const res = await reportService.transactionbyBranch()
      context.commit('setReportForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async bestSellerSparepart(context) {
    try {
      const res = await reportService.bestSellerSparepart()
      context.commit('setReportForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async serviceSelling(context, payload) {
    try {
      const res = await reportService.serviceSelling(payload.year,payload.month)
      context.commit('setReportForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async remainingStock(context, payload) {
    try {
      console.log(payload.sparepart)
      const res = await reportService.remainingStock(payload.year,payload.sparepart)
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

  async printExpenseperYear(context, id) {
    try {
      await reportService.printExpenseperYear(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async printTransactionbyBranch(context) {
    try {
      await reportService.printTransactionperYear2()
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async printRemainingStock(context, payload) {
    try {
      await reportService.printRemainingStock(payload.year,payload.sparepart)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async printServiceSelling(context, payload) {
    try {
      await reportService.printserviceSelling(payload.year,payload.month)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async printBestSellerSparepart(context) {
    try {
      await reportService.printbestSellerSparepart()
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