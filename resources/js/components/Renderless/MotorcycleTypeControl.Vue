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
import motorcycleTypeService from '../../service/MotorcycleType'

export default {
  computed: {
    ...mapState({
      loading: state => state.MotorcycleType.loading,
      error: state => state.MotorcycleType.error,
      items: state => state.MotorcycleType.motorcycleTypes
    })
  },

  methods: {
    ...mapActions({
      fetch: 'MotorcycleType/get' 
    }),
  },

  mounted () {
    this.fetch()
  }
}
</script>

