<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
    <card>
      <v-container grid-list-md mb-0>
        <h1 class="text-md-center">DATA PELANGGAN</h1>
      </v-container> 
      <v-layout row wrap>
        <v-flex xs6>
            <VBtn
            depressed
            dark
            round
            color = "green accent-3"
            @click="dialog = true"
            >
            <VIcon>add</VIcon>
                Tambah Pelanggan
            </VBtn>
        </v-flex>
        <v-flex xs6 class="text-xs-right">
            <VBtn
            icon
            @click="fetch()"
            >
                <VIcon>refresh</VIcon>
            </VBtn>
            <CardSearchBar v-model="keyword" />
        </v-flex>
       </v-layout>
      <CustomerControl ref="customerControl">
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
              <td v-html="props.item.id_customer" />
              <td v-html="props.item.customer_name" />
              <td v-html="props.item.customer_address" />
              <td v-html="props.item.customer_phone_number" />
              <td class="text-xs-center">
                <VBtn 
                  flat
                  icon
                  color="indigo"
                  dark
                  @click="editHandler(props.item.id_customer)"
                >
                  <v-icon>edit</v-icon>
                </VBtn>
                <VBtn 
                  flat
                  icon
                  color="error"
                  dark
                  @click="deleteWarning(props.item.id_customer)"
                >
                  <v-icon>delete</v-icon>
                </VBtn>
              </td>
            </template>
          </VDataTable>
        </template>
      </CustomerControl>
      <v-dialog v-model="dialog" max-width="600px">
        <UtilityCard title="Tambah Pelanggan">
            <VCardText>
                <VAlert
                v-if="customerError"
                v-html="customerError.message"
                :value="true"
                dismissible
                type="error"
                />
                <CustomerForm 
                v-model="isFormValid"
                @submitted="submitHandler"
                />
            </VCardText>
        </UtilityCard>
      </v-dialog>
      <v-dialog v-model="dialog2" max-width="600px">
        <UtilityCard title="Ubah Data Pelanggan">
            <VCardText>
                <VAlert
                v-if="customerError"
                v-html="customerError.message"
                :value="true"
                dismissible
                type="error"
                />
                <CustomerForm 
                v-model="isFormValid"
                @submitted="submitHandler2"  
                />
            </VCardText>
        </UtilityCard>
      </v-dialog>
      <v-dialog v-model="warning" persistent max-width="500">
        <v-card>
            <v-card-title class="headline">Warning!</v-card-title>
            <v-card-text class="text-md-center" style="font-size:15px">Anda yakin ingin menghapus data ini?</v-card-text>
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
import CustomerForm from '../../components/Form/CustomerForm'
import CustomerControl from '../../components/Renderless/CustomerControl'
import customerService from '../../service/Customer'
import { mapActions,mapState } from 'vuex';

export default {
  components: {
    CustomerControl,
    CustomerForm
  },
  data () {
    return {
      name: '',
      isFormValid: false,
      dialog: false,
      dialog2: false,
      warning: false,
      keyword: '',
      id_customer: '',
      headers: [
          {
            text: 'ID',
            value: 'id_customer',
          },
          {
            text: 'Nama',
            value: 'customer_name'
          },
          {
            text: 'Alamat',
            value: 'customer_address'
          },
          {
            text: 'Nomor Telepon',
            value: 'customer_phone_number'
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
          text: 'Pelanggan',
          disabled: true,
        },
      ]
    }
  },

  computed: {
    ...mapState({
      customerError: state => state.Customer.error,
      customerLoading: state => state.Customer.loading
    })
  },


  methods: {
    ...mapActions({
      deleteCustomer: 'Customer/delete',
      storeCustomer: 'Customer/store',
      resetForm: 'Customer/resetForm',
      updateCustomer: 'Customer/update',
      fetchCustomer: 'Customer/edit',
    }),

    fetch () {
      this.$refs.customerControl.fetch()
    },

    async editHandler(id){
      this.id_customer=id
      await this.fetchCustomer(id)
      this.dialog2=true
    },

    deleteWarning(id){
        this.id_customer=id
        this.warning=true
    },

    async deleteHandler () {
      console.log(this.id_customer);
      await this.deleteCustomer(this.id_customer)
      this.fetch()
      this.warning=false
    },

    async submitHandler (value) {
      const payload = {
        customer_name: value.customer_name,
        customer_address: value.customer_address,
        customer_phone_number: value.customer_phone_number
      }

      await this.storeCustomer(payload)
    
      if (!this.customerError) {
        this.dialog=false
        this.fetch()
      }
    },

    async submitHandler2 (value) {
      console.log(this.id_customer);
      const payload = {
        id_customer: this.id_customer,
        customer_name: value.customer_name,
        customer_address: value.customer_address,
        customer_phone_number: value.customer_phone_number
      }

      await this.updateCustomer(payload)
    
      if (!this.customerError) {
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


