import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/sparepart_types')
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data sparepart_types!')
    }
  },

  async store (payload) {
    try {
      await http.post('/api/sparepart_types', payload)
    } catch (err) {
      throw new Error('Gagal simpan sparepart_types baru!')
    }
  },

  async find (id) {
    try {
      const res = await http.get(`/api/sparepart_types/${id}`)
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data sparepart_types!')
    }
  },

  async update (id, payload) {
    try {
      const res = await http.patch(`/api/sparepart_types/${id}`, payload)

      return res.data.data
    } catch (err) {
      throw new Error('Gagal update data sparepart_types!')
    }
  },

  async delete (id) {
    try {
      await http.delete(`/api/sparepart_types/${id}`)
    } catch (err) {
      throw new Error('Gagal hapus data sparepart_types')
    }
  }
}
