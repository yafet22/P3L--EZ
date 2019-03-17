<template>
  <div>
    <slot 
      :loading="loading"
      :error="error"
      :items="items"
    />
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'
import employeeService from '../../service/Employee'

export default {
  computed: {
    ...mapState({
      loading: state => state.Employee.loading,
      error: state => state.Employee.error,
      items: state => state.Employee.employees
    })
  },

  methods: {
    ...mapActions({
      fetch: 'Employee/get' 
    }),
  },

  mounted () {
    this.fetch()
  }
}
</script>

