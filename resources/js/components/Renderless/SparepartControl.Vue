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
import sparepartService from '../../service/Sparepart'

export default {
  computed: {
    ...mapState({
      loading: state => state.Sparepart.loading,
      error: state => state.Sparepart.error,
      items: state => state.Sparepart.spareparts
    })
  },

  methods: {
    ...mapActions({
      fetch: 'Sparepart/get' 
    }),
  },

  mounted () {
    this.fetch()
  }
}
</script>

