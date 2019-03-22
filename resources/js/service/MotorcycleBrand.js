import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/motorcycle_brands')
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data motorcycle_brands!')
    }
  },

  async store (payload) {
    try {
      await http.post('/api/motorcycle_brands', payload)
    } catch (err) {
      throw new Error('Gagal simpan motorcycle_brands baru!')
    }
  },

  async find (id) {
    try {
      const res = await http.get(`/api/motorcycle_brands/${id}`)
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data motorcycle_brands!')
    }
  },

  async update (id, payload) {
    try {
      const res = await http.patch(`/api/motorcycle_brands/${id}`, payload)

      return res.data.data
    } catch (err) {
      throw new Error('Gagal update data motorcycle_brands!')
    }
  },

  async delete (id) {
    try {
      await http.delete(`/api/motorcycle_brands/${id}`)
    } catch (err) {
      throw new Error('Gagal hapus data motorcycle_brands')
    }
  }
}
