import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/employees')
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data karyawan!')
    }
  },

  async store (payload) {
    try {
      await http.post('/api/employees', payload)
    } catch (err) {
      throw new Error('Gagal simpan karyawan baru!')
    }
  },

  async find (id) {
    try {
      const res = await http.get(`/api/employees/${id}`)
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data karyawan!')
    }
  },

  async update (id, payload) {
    try {
      const res = await http.patch(`/api/employees/${id}`, payload)

      return res.data.data
    } catch (err) {
      throw new Error('Gagal update data karyawan!')
    }
  },

  async delete (id) {
    try {
      await http.delete(`/api/employees/${id}`)
    } catch (err) {
      throw new Error('Gagal hapus data karyawan')
    }
  }
}
