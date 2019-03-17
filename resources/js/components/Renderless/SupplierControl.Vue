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
import supplierService from '../../service/Supplier'

export default {
  computed: {
    ...mapState({
      loading: state => state.Supplier.loading,
      error: state => state.Supplier.error,
      items: state => state.Supplier.suppliers
    })
  },

  methods: {
    ...mapActions({
      fetch: 'Supplier/get' 
    }),
  },

  mounted () {
    this.fetch()
  }
}
</script>

