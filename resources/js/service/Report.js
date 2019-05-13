import http from './Http'

export default {

  async transactionperYear(year) {
    try {
      const res = await http.get(`/api/transaction-per-year/${year}`)
      
      return res.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data reports!')
    }
  },
  
  async printTransactionperMonth (year) {
    try {
        await http.get(`/api/generate-transaction-per-month/${year}`)
    } catch (err) {
      throw new Error('Gagal mendapatkan data reports!')
    }
  },

}
