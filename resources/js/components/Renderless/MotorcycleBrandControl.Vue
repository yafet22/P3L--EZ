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
import motorcycleBrandService from '../../service/MotorcycleBrand'

export default {
  computed: {
    ...mapState({
      loading: state => state.MotorcycleBrand.loading,
      error: state => state.MotorcycleBrand.error,
      items: state => state.MotorcycleBrand.motorcycleBrands
    })
  },

  methods: {
    ...mapActions({
      fetch: 'MotorcycleBrand/get' 
    }),
  },

  mounted () {
    this.fetch()
  }
}
</script>

