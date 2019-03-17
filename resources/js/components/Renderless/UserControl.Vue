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
import userService from '../../service/User'

export default {
  computed: {
    ...mapState({
      loading: state => state.User.loading,
      error: state => state.User.error,
      items: state => state.User.users
    })
  },

  methods: {
    ...mapActions({
      fetch: 'User/get' 
    }),
  },

  mounted () {
    this.fetch()
  }
}
</script>

