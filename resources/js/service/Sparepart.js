import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/spareparts')
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data spareparts!')
    }
  },

  async store (payload) {
    try {
      await http.post('/api/spareparts', payload)
    } catch (err) {
      throw new Error('Gagal simpan spareparts baru!')
    }
  },

  async find (id) {
    try {
      const res = await http.get(`/api/spareparts/${id}`)
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data spareparts!')
    }
  },

  async update (id, payload) {
    try {
      console.log("pp")
      const res = await http.post(`/api/updatesparepart/${id}`, payload)

      return res.data.data
    } catch (err) {
      throw new Error('Gagal update data spareparts!')
    }
  },

  async delete (id) {
    try {
      await http.delete(`/api/spareparts/${id}`)
    } catch (err) {
      throw new Error('Gagal hapus data spareparts')
    }
  },

  async verification (payload) {
    try {
      await http.post(`/api/updatesparepart`, payload)
    } catch (err) {
      throw new Error('Gagal update data spareparts!')
    }
  },
}
