import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/services')
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data services!')
    }
  },

  async store (payload) {
    try {
      await http.post('/api/services', payload)
    } catch (err) {
      throw new Error('Gagal simpan services baru!')
    }
  },

  async find (id) {
    try {
      const res = await http.get(`/api/services/${id}`)
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data services!')
    }
  },

  async update (id, payload) {
    try {
      const res = await http.patch(`/api/services/${id}`, payload)

      return res.data.data
    } catch (err) {
      throw new Error('Gagal update data services!')
    }
  },

  async delete (id) {
    try {
      await http.delete(`/api/services/${id}`)
    } catch (err) {
      throw new Error('Gagal hapus data services')
    }
  }
}
