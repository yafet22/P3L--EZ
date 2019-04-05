<template>
  <VApp>
    <AdminNavbar v-if="!isLoginPage"/>
    <VContent >
        <router-view />
    </VContent>
  </VApp>
</template>

<script>
  import AdminNavbar from '../components/Navbar/AdminNavbar'

  export default {
    components: {
      AdminNavbar,
    },

    computed: {
      isLoginPage() {
        return this.$route.name === 'login'
      }
    },
  }

</script>
