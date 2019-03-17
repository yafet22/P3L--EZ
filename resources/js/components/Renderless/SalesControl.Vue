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
import salesService from '../../service/Sales'

export default {
  computed: {
    ...mapState({
      loading: state => state.Sales.loading,
      error: state => state.Sales.error,
      items: state => state.Sales.salesmany
    })
  },

  methods: {
    ...mapActions({
      fetch: 'Sales/get' 
    }),
  },

  mounted () {
    this.fetch()
  }
}
</script>

