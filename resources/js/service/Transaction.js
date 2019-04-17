import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/transactions')
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data transaction!')
    }
  },

  async store (payload) {
    try {
      await http.post('/api/transactions', payload)
    } catch (err) {
      throw new Error('Gagal simpan transaction baru!')
    }
  },

  async find (id) {
    try {
      const res = await http.get(`/api/transactions/${id}`)
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data transaction!')
    }
  },

  async update (id, payload) {
    try {
      const res = await http.patch(`/api/transactions/${id}`, payload)

      return res.data.data
    } catch (err) {
      throw new Error('Gagal update data transaction!')
    }
  },
  
  async delete (id) {
    try {
      await http.delete(`/api/transactions/${id}`)
    } catch (err) {
      throw new Error('Gagal hapus data transaction')
    }
  }
}
