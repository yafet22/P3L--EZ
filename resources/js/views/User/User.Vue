<template>
  <PageWrapper :narrow="true" :breadcrumbs="breadcrumbs">
    <card>
      <v-container grid-list-md mb-0>
        <h1 class="text-md-center">DATA USER</h1>
      </v-container> 
      <v-layout row wrap>
        <v-flex xs12 class="text-xs-right">
            <VBtn
            icon
            @click="fetch()"
            >
                <VIcon>refresh</VIcon>
            </VBtn>
            <CardSearchBar v-model="keyword" />
        </v-flex>
       </v-layout>
      <UserControl ref="userControl">
        <template slot-scope="{ loading, error, items }">
          <VCardText
            v-if="loading || error"
            class="text-xs-center"
          >
            <VAlert
              v-if="error"
              type="error"
              dismissible
              :value="true"
            >
              {{ error.message }}
            </VAlert>
            <VProgressCircular
              :size="45"
              indeterminate
              class="loading-section"
            />
          </VCardText>
          <VDataTable
            :headers="headers"
            :items="items"
            :search="keyword"
            v-if="!loading && !error"
          >
            <template slot="items" slot-scope="props">
              <td v-html="props.item.id" />
              <td v-html="props.item.username" />
              <td class="text-xs-center">
                <VBtn 
                  flat
                  icon
                  color="indigo"
                  dark
                  @click="editHandler(props.item.id)"
                >
                  <v-icon>edit</v-icon>
                </VBtn>
                <VBtn 
                  flat
                  icon
                  color="error"
                  dark
                  @click="deleteWarning(props.item.id)"
                >
                  <v-icon>delete</v-icon>
                </VBtn>
              </td>
            </template>
          </VDataTable>
        </template>
      </UserControl>
      <v-dialog v-model="dialog2" max-width="600px">
        <UtilityCard title="Ubah Data User">
            <VCardText>
                <VAlert
                v-if="userError"
                v-html="userError.message"
                :value="true"
                dismissible
                type="error"
                />
                <UserForm 
                v-model="isFormValid"
                @submitted="submitHandler2"
                />
            </VCardText>
        </UtilityCard>
      </v-dialog>
      <v-dialog v-model="warning" persistent max-width="500">
        <v-card>
            <v-card-title class="headline">Warning!</v-card-title>
            <VCardText
              v-if="userLoading || userError"
              class="text-xs-center"
            >
              <VAlert
                v-if="userError"
                :value="true"
                dismissible
                type="error"
              >
              {{ userError.message }}
              </VAlert>
              <VProgressCircular
                v-if="userLoading"
                :size="45"
                indeterminate
                class="loading-section"
              />
            </VCardText>
            <v-card-text v-else class="text-md-center" style="font-size:15px">Anda yakin ingin menghapus data ini?</v-card-text>
            <v-card-actions>
            <v-spacer/>
            <VBtn class="mb-4" depressed dark color="red accent-3" @click="warning = false">Disagree</VBtn>
            <VBtn class="mb-4" depressed dark color="green accent-3" @click="deleteHandler()">Agree</VBtn>
            <v-spacer/>
            </v-card-actions>
        </v-card>
      </v-dialog>
    </card>
  </PageWrapper>
</template>

<script>
import UserForm from '../../components/Form/UserForm'
import UserControl from '../../components/Renderless/UserControl'
import userService from '../../service/User'
import { mapActions,mapState } from 'vuex';

export default {
  components: {
    UserControl,
    UserForm
  },
  data () {
    return {
      name: '',
      isFormValid: false,
      dialog: false,
      dialog2: false,
      warning: false,
      keyword: '',
      id: '',
      headers: [
          {
            text: 'ID',
            value: 'id',
          },
          {
            text: 'Username',
            value: 'username'
          },
          {
            text: 'Aksi',
            value: null
          },
      ],
      breadcrumbs: [
        {
          text: 'Dashboard',
          to: { name: 'dashboard' },
          exact: true,
        },
        {
          text: 'User',
          disabled: true,
        },
      ]
    }
  },

  computed: {
    ...mapState({
      userError: state => state.User.error,
      userLoading: state => state.User.loading
    })
  },


  methods: {
    ...mapActions({
      deleteUser: 'User/delete',
      storeUser: 'User/store',
      resetForm: 'User/resetForm',
      updateUser: 'User/update',
      fetchUser: 'User/edit',
    }),

    fetch () {
      this.$refs.userControl.fetch()
    },

    editHandler(id){
      console.log(id)
      this.id=id
      this.dialog2=true
    },

    deleteWarning(id){
        this.id=id
        this.warning=true
    },

    async deleteHandler () {
      console.log(this.id);
      await this.deleteUser(this.id)
      this.fetch()
      this.warning=false
    },

    async submitHandler2 (value) {
      
      console.log(this.id);
      const payload = {
        id: this.id,
        password: value.password
      }
      console.log(payload)
      await this.updateUser(payload)
    
      if (!this.userError) {
        this.dialog2=false
        this.fetch()
      }
    },
  },

  mounted () {
    this.resetForm()
  }
}
</script>

<style scoped>
.loading-section {
  text-align: center;
}
</style>


