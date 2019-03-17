import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/roles')
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data role!')
    }
  },

  async store (payload) {
    try {
      await http.post('/api/roles', payload)
    } catch (err) {
      throw new Error('Gagal simpan role baru!')
    }
  },

  async find (id) {
    try {
      const res = await http.get(`/api/roles/${id}`)
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data role!')
    }
  },

  async update (id, payload) {
    try {
      const res = await http.patch(`/api/roles/${id}`, payload)

      return res.data.data
    } catch (err) {
      throw new Error('Gagal update data role!')
    }
  },

  async delete (id) {
    try {
      await http.delete(`/api/roles/${id}`)
    } catch (err) {
      throw new Error('Gagal hapus data role')
    }
  }
}
