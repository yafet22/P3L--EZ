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
        <VList-group
          v-for="menu in dropmenus"
          :key="menu.id"
          :prepend-icon="menu.icon"
          class="ml-1"
        >
          <template v-slot:activator>
            <v-list-tile>
              <v-list-tile-title>{{menu.text}}</v-list-tile-title>
            </v-list-tile>
          </template>
          <VListTile 
            v-for="submenu in submenus"
            :key="submenu.id"
            @click="$router.push({ name: submenu.to })"
          >
            <VListTileAction>
              <VIcon>{{ submenu.icon }}</VIcon>
            </VListTileAction>
            <VListTileContent>
              <VListTileTitle v-html="submenu.text" />
            </VListTileContent>
          </VListTile>
        </VList-group>
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

      dropmenus(){
        switch (this.role) {
          case 'Administrator': 
            return [
              { id: 'd1', icon: 'motorcycle',text: 'Motorcycle', name: 'Motorcycle'},
            ]
            break
        }
      },

      submenus(){
        switch (this.role) {
          case 'Administrator': 
            return [
              { id: 's1', icon: 'filter_1', to: 'motorcycleBrands', text: 'MotorcycleBrand', name: 'MotorcycleBrand'},
              { id: 's2', icon: 'filter_2', to: 'motorcycleTypes', text: 'MotorcycleType', name: 'MotorcycleType'},
            ]
            break
        }
      },

      menus () {
        switch (this.role) {
          case 'Administrator': 
            return [
              { id: 1, to: 'dashboard', icon: 'dashboard', text: 'Dashboard', name: 'Dashboard'},
              { id: 2, to: 'branches', icon: 'location_city', text: 'Cabang', name: 'Branches'},
              { id: 3, to: 'employees', icon: 'person', text: 'Karyawan', name: 'Employees'},
              { id: 4, to: 'users', icon: 'person_outline', text: 'User', name: 'Users'},
              { id: 5, to: 'suppliers', icon: 'store_mall_directory', text: 'Supplier', name: 'Suppliers'},
              { id: 6, to: 'sales', icon: 'people', text: 'Sales', name: 'Sales'},
              { id: 7, to: 'services', icon: 'pan_tool', text: 'Service', name: 'Service'},
              { id: 8, to: 'spareparts', icon: 'build', text: 'Sparepart', name: 'Sparepart'},
              { id: 9, to: 'customers', icon: 'accessibility', text: 'Customer', name: 'Customer'},
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

