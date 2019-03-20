import employeeService from '../../service/Employee'

const state = {
  employees: [],
  employee: {
    first_name: '',
    last_name: '',
    salary: '',
    phone_number: '',
    address: '',
    id_user: '',
    id_branch: '',
    id_role: '',

  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.employees = payload
    state.loading = false
    state.error = null
  },

  setFailedAction(state, payload) {
    state.loading = false
    state.error = payload.error
  },

  setEmployeeForm(state, payload) {
    state.employee.first_name = payload.name
    state.employee.last_name = payload.last_name
    state.employee.address = payload.address
    state.employee.phone_number = payload.phone_number
    state.employee.salary = payload.salary
    state.employee.id_branch = payload.id_branch
    state.employee.id_role = payload.id_role
  }
}

const getters = {
  error: state => state.error,
  loading: state => state.loading,
  employee: state => state.employee
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await employeeService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await employeeService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      const res = await employeeService.find(id)
      context.commit('setEmployeeForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      const data = {
        first_name: payload.first_name,
        last_name: payload.last_name,
        address: payload.address,
        phone_number: payload.phone_number,
        salary: payload.salary,
        id_branch: payload.id_branch,
        id_role: payload.id_role
      }

      await employeeService.update(payload.id_employee, data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await employeeService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('setEmployeeForm', {})
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}