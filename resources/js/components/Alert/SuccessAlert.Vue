<template>
  <div>
    <VAlert 
      dismissible 
      outline
      type="success"
      v-model="success"
    >
      {{ message }}
    </VAlert>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        success: false,
        message: 'Berhasil!'
      }
    },

    methods: {
      trigger (success) {
        this.success = true
        this.message = success.message
      },

      reset () {
        this.success = false
        this.message = 'Berhasil!'
      }
    }
  }
</script>

