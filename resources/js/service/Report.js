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
  
  async serviceSelling(year,month) {
    try {
      const res = await http.get(`/api/service-selling/${year}/${month}`)
      
      return res.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data reports!')
    }
  },

  async bestSellerSparepart() {
    try {
      const res = await http.get(`/api/best-seller-sparepart`)
      
      return res.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data reports!')
    }
  },
  
  async printTransactionperMonth (year) {
    try {
        await http.download(`/api/generate-transaction-per-month/${year}`)
    } catch (err) {
      throw new Error('Gagal mendapatkan data reports!')
    }
  },

  async printserviceSelling (year,month) {
    try {
        await http.download(`/api/generate-service-selling/${year}/${month}`)
    } catch (err) {
      throw new Error('Gagal mendapatkan data reports!')
    }
  },

  async printbestSellerSparepart() {
    try {
        await http.download(`/api/generate-sparepart-best-seller`)
    } catch (err) {
      throw new Error('Gagal mendapatkan data reports!')
    }
  },

}
