<template>
  <div>
    <VNavigationDrawer
      v-model="drawer"
      app
      clipped
      fixed
      temporary
    >
      <VList>
        <VListTile avatar>
          <VListTileAvatar>
            <VIcon style="font-size: 50px;">account_circle</VIcon>
          </VListTileAvatar>
          <VListTileContent>
            <VListTileTitle class="text-xs-center">Hi, {{ name }}</VListTileTitle>
            <VListTileTitle class="text-md-center">{{ role }}</VListTileTitle>
          </VListTileContent>
        </VListTile>
      </VList>

      <VList>
        <VDivider />

        <VListTile 
          v-for="menu in menus"
          :key="menu.id"
          class="ml-1"
          @click="$router.push({ name: menu.to })"
        >
          <VListTileAction>
            <VIcon>{{ menu.icon }}</VIcon>
          </VListTileAction>

          <VListTileContent>
            <VListTileTitle v-html="menu.text" />
          </VListTileContent>
        </VListTile>
      </VList>
    </VNavigationDrawer>

    <VToolbar 
      dark 
      app
      fixed
      clipped-left
      height="70px"
      color="blue darken-2">

      <VToolbarSideIcon 
        @click.stop="drawer = !drawer"
      />

      <VSpacer />
    
      
      <img src="http://localhost:8000/asset/icons.png" style="height:45px;width:45px">
      
      <VToolbarTitle
        style="font-size: 21px;"
        class="white--text ml-2"
      > 
        SIBAAU
      </VToolbarTitle>

      <VMenu 
        offset-y
        bottom
        left
      >
        <VBtn 
          icon
          slot="activator"
        >
          <VIcon>more_vert</VIcon>
        </VBtn>

        <VList>
          <VListTile>
            <VListTileTitle>Ubah Password</VListTileTitle>
          </VListTile>
          <VListTile @click="logoutHandler">
            <VListTileTitle>Logout</VListTileTitle>
          </VListTile>
        </VList>
      </VMenu>
    </VToolbar>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import Auth from '../../service/Auth'

  export default {
    data() {
      return {
        drawer: null,
      }
    },

    computed: {
      ...mapGetters({
        name: 'LoggedUser/name',
        username: 'LoggedUser/username',
        role: 'LoggedUser/role'
      }),

      menus () {
        switch (this.role) {
          case 'Administrator': 
            return [
              { id: 1, to: 'dashboard', icon: 'dashboard', text: 'Dashboard', name: 'Dashboard'},
              { id: 2, to: 'branches', icon: 'location_city', text: 'Cabang', name: 'Branches'},
              { id: 3, to: 'employees', icon: 'person', text: 'Karyawan', name: 'Employees'},
            ]
            break

          case 'Customer Service': 
            return [
              { id: 1, to: 'dashboard', icon: 'dashboard', text: 'Dashboard', name: 'Dashboard' },
            ]
            break

          case 'Cashier': 
            return [
              { id: 1, to: 'dashboard', icon: 'dashboard', text: 'Dashboard', name: 'Dashboard' },
            ]
            break
        }
      }
    },

    methods: {
      logoutHandler() {
        Auth.logout()
        this.$router.push({ name: 'login' })
      },

    } 
  }
</script>

