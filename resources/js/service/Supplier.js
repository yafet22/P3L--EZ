import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/suppliers')
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data supplier!')
    }
  },

  async store (payload) {
    try {
      await http.post('/api/suppliers', payload)
    } catch (err) {
      throw new Error('Gagal simpan supplier baru!')
    }
  },

  async find (id) {
    try {
      const res = await http.get(`/api/suppliers/${id}`)
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data supplier!')
    }
  },

  async update (id, payload) {
    try {
      const res = await http.patch(`/api/suppliers/${id}`, payload)

      return res.data.data
    } catch (err) {
      throw new Error('Gagal update data supplier!')
    }
  },
  
  async delete (id) {
    try {
      await http.delete(`/api/suppliers/${id}`)
    } catch (err) {
      throw new Error('Gagal hapus data supplier')
    }
  }
}
