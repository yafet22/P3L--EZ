import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/users')
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data user!')
    }
  },

  async store (payload) {
    try {
      await http.post('/api/users', payload)
    } catch (err) {
      throw new Error('Gagal simpan user baru!')
    }
  },

  async find (id) {
    try {
      const res = await http.get(`/api/users/${id}`)
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data user!')
    }
  },

  async update (id, payload) {
    try {

      const res = await http.patch(`/api/users/${id}`, payload)

      return res.data.data
    } catch (err) {
      throw new Error('Gagal update data user!')
    }
  },

  async delete (id) {
    try {
      await http.delete(`/api/users/${id}`)
    } catch (err) {
      throw new Error('Gagal hapus data user')
    }
  }
}
