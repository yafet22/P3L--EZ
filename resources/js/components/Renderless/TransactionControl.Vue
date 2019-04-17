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
import transactionService from '../../service/Transaction'

export default {
  computed: {
    ...mapState({
      loading: state => state.Transaction.loading,
      error: state => state.Transaction.error,
      items: state => state.Transaction.transactions
    })
  },

  methods: {
    ...mapActions({
      fetch: 'Transaction/get' 
    }),
  },

  mounted () {
    this.fetch()
  }
}
</script>

