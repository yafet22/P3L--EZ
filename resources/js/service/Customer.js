import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/customers')
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data customer!')
    }
  },

  async store (payload) {
    try {
      await http.post('/api/customers', payload)
    } catch (err) {
      throw new Error('Gagal simpan customer baru!')
    }
  },

  async find (id) {
    try {
      const res = await http.get(`/api/customers/${id}`)
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data customer!')
    }
  },

  async update (id, payload) {
    try {
      const res = await http.patch(`/api/customers/${id}`, payload)

      return res.data.data
    } catch (err) {
      throw new Error('Gagal update data customer!')
    }
  },

  async delete (id) {
    try {
      await http.delete(`/api/customers/${id}`)
    } catch (err) {
      throw new Error('Gagal hapus data customer')
    }
  }
}
