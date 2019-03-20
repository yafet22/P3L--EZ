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
import serviceService from '../../service/Service'

export default {
  computed: {
    ...mapState({
      loading: state => state.Service.loading,
      error: state => state.Service.error,
      items: state => state.Service.services
    })
  },

  methods: {
    ...mapActions({
      fetch: 'Service/get' 
    }),
  },

  mounted () {
    this.fetch()
  }
}
</script>

