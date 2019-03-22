import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/motorcycle_types')
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data motorcycle_types!')
    }
  },

  async store (payload) {
    try {
      await http.post('/api/motorcycle_types', payload)
    } catch (err) {
      throw new Error('Gagal simpan motorcycle_types baru!')
    }
  },

  async find (id) {
    try {
      const res = await http.get(`/api/motorcycle_types/${id}`)
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data motorcycle_types!')
    }
  },

  async update (id, payload) {
    try {
      const res = await http.patch(`/api/motorcycle_types/${id}`, payload)

      return res.data.data
    } catch (err) {
      throw new Error('Gagal update data motorcycle_types!')
    }
  },

  async delete (id) {
    try {
      await http.delete(`/api/motorcycle_types/${id}`)
    } catch (err) {
      throw new Error('Gagal hapus data motorcycle_types')
    }
  }
}
