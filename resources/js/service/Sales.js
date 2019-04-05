import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/sales')
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data sales!')
    }
  },

  async store (payload) {
    try {
      await http.post('/api/sales', payload)
    } catch (err) {
      throw new Error('Gagal simpan sales baru!')
    }
  },

  async find (id) {
    try {
      const res = await http.get(`/api/sales/${id}`)
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data sales!')
    }
  },

  async update (id, payload) {
    try {
      const res = await http.patch(`/api/sales/${id}`, payload)

      return res.data.data
    } catch (err) {
      throw new Error('Gagal update data sales!')
    }
  },

  async delete (id) {
    try {
      await http.delete(`/api/sales/${id}`)
    } catch (err) {
      throw new Error('Gagal hapus data sales')
    }
  },

  async findBySupplier (id) {
    try {
      const res = await http.get(`/api/suppliersales/${id}`)
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data sales!')
    }
  }
}
