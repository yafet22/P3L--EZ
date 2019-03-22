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
import customerService from '../../service/Customer'

export default {
  computed: {
    ...mapState({
      loading: state => state.Customer.loading,
      error: state => state.Customer.error,
      items: state => state.Customer.customers
    })
  },

  methods: {
    ...mapActions({
      fetch: 'Customer/get' 
    }),
  },

  mounted () {
    this.fetch()
  }
}
</script>

