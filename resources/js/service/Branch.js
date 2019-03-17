import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/branches')
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data cabang!')
    }
  },

  async store (payload) {
    try {
      await http.post('/api/branches', payload)
    } catch (err) {
      throw new Error('Gagal simpan cabang baru!')
    }
  },

  async find (id) {
    try {
      const res = await http.get(`/api/branches/${id}`)
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data cabang!')
    }
  },

  async update (id, payload) {
    try {
      const res = await http.patch(`/api/branches/${id}`, payload)

      return res.data.data
    } catch (err) {
      throw new Error('Gagal update data cabang!')
    }
  },

  async delete (id) {
    try {
      await http.delete(`/api/branches/${id}`)
    } catch (err) {
      throw new Error('Gagal hapus data cabang')
    }
  }
}
