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
import motorcycleService from '../../service/Motorcycle'

export default {
  computed: {
    ...mapState({
      loading: state => state.Motorcycle.loading,
      error: state => state.Motorcycle.error,
      items: state => state.Motorcycle.motorcycles
    })
  },

  methods: {
    ...mapActions({
      fetch: 'Motorcycle/get' 
    }),
  },

  mounted () {
    this.fetch()
  }
}
</script>

