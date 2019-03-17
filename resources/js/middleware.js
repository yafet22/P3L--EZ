import authService from './service/Auth'
import store from './store'

export async function auth(to, from, next) {
  if (!authService.getToken()) {
    next({ name: 'login' })
  } else {
    try {
      await authService.refresh()
      console.log(store.getters['LoggedUser/role'])
      let role = store.getters['LoggedUser/role']
      
      if (to.meta.role.includes(role)) {
        next()
      } else {
        next({ name: 'dashboard' }) // Fallback if the role doesn't have any permission to access page
      }
    } catch (err) {
      next({ name: 'login' })
    }
  }
}

export default function middleware(guards) {
  return (to, from, next) => {
    guards.forEach(async (guard) => {
        await guard(to, from, next)
    })
  }
}