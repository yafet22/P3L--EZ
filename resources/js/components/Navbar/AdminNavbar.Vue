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
        <VList-group
          v-for="menu in dropmenus2"
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
            v-for="submenu in submenus2"
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
    
      
      <img src="/asset/icons.png" style="height:45px;width:45px">
      
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
          <VListTile @click="dialog=true">
            <VListTileTitle>Ubah Password</VListTileTitle>
          </VListTile>
          <VListTile @click="logoutHandler">
            <VListTileTitle>Logout</VListTileTitle>
          </VListTile>
        </VList>
      </VMenu>
    </VToolbar>
    <v-dialog v-model="dialog" max-width="600px">
      <UtilityCard title="Ubah Password">
          <VAlert
            v-if="err"
            :value="true"
            dismissible
            type="error"
          >
          Password Tidak Cocok dengan Konfirmasi
          </VAlert>
          <VAlert
            v-else-if="success"
            :value="true"
            dismissible
            type="success"
          >
          Berhasil Ubah Password
          </VAlert>
          <VCardText>
            <UserForm 
              v-model="isFormValid"
              @submitted="submitHandler"
            />
          </VCardText>
      </UtilityCard>
    </v-dialog>
  </div>
</template>

<script>
  import UserForm from '../Form/UserForm'
  import { mapGetters,mapActions } from 'vuex'
  import Auth from '../../service/Auth'

  export default {
    components: {
      UserForm
    },
    data() {
      return {
        drawer: null,
        isFormValid: false,
        dialog: false,
        err: false,
        success: false
      }
    },

    computed: {
      ...mapGetters({
        id: 'LoggedUser/id',
        name: 'LoggedUser/name',
        username: 'LoggedUser/username',
        role: 'LoggedUser/role'
      }),

      dropmenus(){
        switch (this.role) {
          case 'Administrator': 
            return [
              { id: 'd1', icon: 'motorcycle',text: 'Data Master Motor', name: 'Motorcycle'},
            ]
            break
        }
      },

      dropmenus2(){
        switch (this.role) {
          case 'Administrator': 
            return [
              { id: 'd1', icon: 'motorcycle',text: 'Report', name: 'Report'},
            ]
            break
        }
      },

      submenus(){
        switch (this.role) {
          case 'Administrator': 
            return [
              { id: 's1', icon: 'filter_1', to: 'motorcycleBrands', text: 'Merk Motor', name: 'MotorcycleBrand'},
              { id: 's2', icon: 'filter_2', to: 'motorcycleTypes', text: 'Tipe Motor', name: 'MotorcycleType'},
            ]
            break
        }
      },

      submenus2(){
        switch (this.role) {
          case 'Administrator': 
            return [
              { id: 'p1', icon: 'filter_1', to: 'transactionperYear', text: 'Transaksi per Bulan', name: 'transactionperYear'},
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
              { id: 9, to: 'customers', icon: 'accessibility', text: 'Pelanggan', name: 'Customer'},
              { id: 10, to: 'procurements', icon: 'airport_shuttle', text: 'Pengadaan Sparepart', name: 'procurement'},
              { id: 11, to: 'transactions', icon: 'euro_symbol', text: 'Transaksi', name: 'transaction'},
            ]
            break

          case 'Customer Service': 
            return [
              { id: 1, to: 'dashboard', icon: 'dashboard', text: 'Dashboard', name: 'Dashboard' },
              { id: 2, to: 'transactions', icon: 'euro_symbol', text: 'Transaksi', name: 'transaction'},
            ]
            break

          case 'Cashier': 
            return [
              { id: 1, to: 'dashboard', icon: 'dashboard', text: 'Dashboard', name: 'Dashboard' },
              { id: 2, to: 'transactions', icon: 'euro_symbol', text: 'Transaksi', name: 'transaction'},
            ]
            break
        }
      }
    },

    methods: {
      ...mapActions({
        resetForm: 'User/resetForm',
        updateUser: 'User/update',
      }),
      logoutHandler() {
        Auth.logout()
        this.$router.push({ name: 'login' })
      },
      async submitHandler (value) {
        this.err = false
        if(value.password === value.confirmPassword)
        {
            console.log(this.id);
            const payload = {
              id: this.id,
              password: value.password
            }
            console.log(payload)
            await this.updateUser(payload)
            this.success=true
            this.dialog=false  
            this.err = false      
        }
        else
        {
            this.err = true
        }
        
      },

    } 
  }
</script>

