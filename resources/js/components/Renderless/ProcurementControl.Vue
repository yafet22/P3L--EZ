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
import procurementService from '../../service/Procurement'

export default {
  computed: {
    ...mapState({
      loading: state => state.Procurement.loading,
      error: state => state.Procurement.error,
      items: state => state.Procurement.procurements
    })
  },

  methods: {
    ...mapActions({
      fetch: 'Procurement/get' 
    }),
  },

  mounted () {
    this.fetch()
  }
}
</script>

