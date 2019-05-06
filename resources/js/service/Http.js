import axios from 'axios'

export default {
  init() {
    axios.defaults.baseURL = 'http://127.0.0.1/'
  },

  setHeader (token) {
    axios.defaults.headers.common['Authorization'] = 'Basic ' + btoa(token.username + ':' + token.password)
  },

  getHeader () {
    return axios.defaults.headers.common['Authorization']
  },

  get(url) {
    try {
      return axios.request({
        url,
        method: 'get'
      })
    } catch (err) {
      throw err
    }
  },

  post(url, data) {
    try {
      return axios.request({
        url,
        data,
        method: 'post'
      })
    } catch (err) {
      throw err
    }
  },

  patch(url, data) {
    try {
      return axios.request({
        url,
        data,
        method: 'patch'
      })
    } catch (err) {
      throw err
    }
  },

  put(url, data) {
    try {
      return axios.request({
        url,
        data,
        method: 'put'
      })
    } catch (err) {
      throw err
    }
  },

  delete(url) {
    try {
      return axios.request({
        url,
        method: 'delete'
      })
    } catch (err) {
      throw err
    }
  }
}