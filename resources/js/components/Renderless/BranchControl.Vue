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
import branchService from '../../service/Branch'

export default {
  computed: {
    ...mapState({
      loading: state => state.Branch.loading,
      error: state => state.Branch.error,
      items: state => state.Branch.branches
    })
  },

  methods: {
    ...mapActions({
      fetch: 'Branch/get' 
    }),
  },

  mounted () {
    this.fetch()
  }
}
</script>

