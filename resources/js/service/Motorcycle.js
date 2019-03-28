import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/motorcycles')
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data motorcycles!')
    }
  },

  async store (payload) {
    try {
      await http.post('/api/motorcycles', payload)
    } catch (err) {
      throw new Error('Gagal simpan motorcycles baru!')
    }
  },

  async find (id) {
    try {
      const res = await http.get(`/api/motorcycles/${id}`)
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data motorcycles!')
    }
  },

  async update (id, payload) {
    try {
      const res = await http.patch(`/api/motorcycles/${id}`, payload)

      return res.data.data
    } catch (err) {
      throw new Error('Gagal update data motorcycles!')
    }
  },

  async delete (id) {
    try {
      await http.delete(`/api/motorcycles/${id}`)
    } catch (err) {
      throw new Error('Gagal hapus data motorcycles')
    }
  },

  async findByUser (id) {
    try {
      const res = await http.get(`/api/usermotorcycles/${id}`)
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data motorcycles!')
    }
  }
}
