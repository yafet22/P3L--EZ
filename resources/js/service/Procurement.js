import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/procurements')
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data procurements!')
    }
  },

  async store (payload) {
    try {
      await http.post('/api/procurements', payload)
    } catch (err) {
      throw new Error('Gagal simpan procurements baru!')
    }
  },

  async find (id) {
    try {
      const res = await http.get(`/api/procurements/${id}`)
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data procurements!')
    }
  },

  async print (id) {
    try {
        await http.get(`/api/generate-procurement-docs/${id}`)
    } catch (err) {
      throw new Error('Gagal mendapatkan data procurements!')
    }
  },

  async update (id, payload) {
    try {
      const res = await http.patch(`/api/procurements/${id}`, payload)

      return res.data.data
    } catch (err) {
      throw new Error('Gagal update data procurements!')
    }
  },

  async delete (id) {
    try {
      await http.delete(`/api/procurements/${id}`)
    } catch (err) {
      throw new Error('Gagal hapus data procurements')
    }
  },
}
