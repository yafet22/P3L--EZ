import Http from './Http'
import Store from '../store'
import Cookie from 'js-cookie'
import { routes } from '../routes/admin'

export default {
  async authenticate ({ username, password }) {
    try {
      const res = await Http.post('/api/authenticate', {
        username,
        password
      })

      const accessToken = {
        username: res.data.data.token_username,
        password: res.data.data.token_password
      }
    
      Http.setHeader(accessToken)
      Cookie.set('accessToken', accessToken)

      Store.commit('LoggedUser/setLoggedUser', await this.whoami())
    } catch (err) {
      throw new Error('Nama pengguna/kata sandi salah')
    }
  },

  async whoami () {
    try {
      const res = await Http.get('/api/whoami')

      return res.data.data
    } catch (err) {
      if (err.response.status === 401) {
        routes.push({ name: 'login' })
      } else {
        throw new Error('Failed fetch authenticated user')
      }
    }
  },

  async refresh () {
    const accessToken = Cookie.get('accessToken')

    if (typeof accessToken === 'undefined') {
      throw new Error('Access token not exist')
    }

    Http.setHeader(JSON.parse(accessToken))
    Store.commit('LoggedUser/setLoggedUser', await this.whoami())
  },

  logout () {
    Store.commit('LoggedUser/setLoggedUser', {})
    Store.commit('LoggedUser/loggedOut')
    Cookie.remove('accessToken')
  },

  getToken () {
    return typeof Cookie.get('accessToken') !== 'undefined'
  }
}