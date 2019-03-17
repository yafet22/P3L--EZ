<template>
  <div>
    <VAlert 
      dismissible 
      outline
      type="error"
      v-model="error"
    >
      {{ message }}
    </VAlert>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        error: false,
        message: 'Gagal!'
      }
    },

    methods: {
      trigger (err) {
        this.error = true
        this.message = err.message
      },

      reset () {
        this.error = false
        this.message = 'Gagal!'
      }
    }
  }
</script>

