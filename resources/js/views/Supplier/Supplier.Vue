<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
    <card>
      <v-container grid-list-md mb-0>
        <h1 class="text-md-center">DATA SUPPLIER</h1>
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
                Tambah Supplier
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
      <SupplierControl ref="supplierControl">
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
              <td v-html="props.item.id_supplier" />
              <td v-html="props.item.supplier_name" />
              <td v-html="props.item.supplier_address" />
              <td v-html="props.item.supplier_phone_number" />
              <td class="text-xs-center">
                <VBtn 
                  flat
                  icon
                  color="indigo"
                  dark
                  @click="editHandler(props.item.id_supplier)"
                >
                  <v-icon>edit</v-icon>
                </VBtn>
                <VBtn 
                  flat
                  icon
                  color="error"
                  dark
                  @click="deleteWarning(props.item.id_supplier)"
                >
                  <v-icon>delete</v-icon>
                </VBtn>
              </td>
            </template>
          </VDataTable>
        </template>
      </SupplierControl>
      <v-dialog v-model="dialog" max-width="600px">
        <UtilityCard title="Tambah Supplier">
            <VCardText>
                <VAlert
                v-if="supplierError"
                v-html="supplierError.message"
                :value="true"
                dismissible
                type="error"
                />
                <SupplierForm 
                v-model="isFormValid"
                @submitted="submitHandler"
                />
            </VCardText>
        </UtilityCard>
      </v-dialog>
      <v-dialog v-model="dialog2" max-width="600px">
        <UtilityCard title="Ubah Data Supplier">
            <VCardText>
                <VAlert
                v-if="supplierError"
                v-html="supplierError.message"
                :value="true"
                dismissible
                type="error"
                />
                <SupplierForm 
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
import SupplierForm from '../../components/Form/SupplierForm'
import SupplierControl from '../../components/Renderless/SupplierControl'
import supplierService from '../../service/Supplier'
import { mapActions,mapState } from 'vuex';

export default {
  components: {
    SupplierControl,
    SupplierForm
  },
  data () {
    return {
      name: '',
      isFormValid: false,
      dialog: false,
      dialog2: false,
      warning: false,
      keyword: '',
      id_supplier: '',
      headers: [
          {
            text: 'ID',
            value: 'id_supplier',
          },
          {
            text: 'Nama',
            value: 'supplier_name'
          },
          {
            text: 'Alamat',
            value: 'supplier_address'
          },
          {
            text: 'Nomor Telepon',
            value: 'supplier_phone_number'
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
          text: 'Supplier',
          disabled: true,
        },
      ]
    }
  },

  computed: {
    ...mapState({
      supplierError: state => state.Supplier.error,
      supplierLoading: state => state.Supplier.loading
    })
  },


  methods: {
    ...mapActions({
      deleteSupplier: 'Supplier/delete',
      storeSupplier: 'Supplier/store',
      resetForm: 'Supplier/resetForm',
      updateSupplier: 'Supplier/update',
      fetchSupplier: 'Supplier/edit',
    }),

    fetch () {
      this.$refs.supplierControl.fetch()
    },

    async editHandler(id){
      console.log(id)
      this.id_supplier=id
      await this.fetchSupplier(id)
      this.dialog2=true
    },

    deleteWarning(id){
        this.id_supplier=id
        this.warning=true
    },

    async deleteHandler () {
      console.log(this.id_supplier);
      await this.deleteSupplier(this.id_supplier)
      this.fetch()
      this.warning=false
    },

    async submitHandler (value) {
      const payload = {
        supplier_name: value.supplier_name,
        supplier_address: value.supplier_address,
        supplier_phone_number: value.supplier_phone_number
      }

      await this.storeSupplier(payload)
    
      if (!this.supplierError) {
        this.dialog=false
        this.fetch()
      }
    },

    async submitHandler2 (value) {
      
      console.log(this.id_supplier);
      const payload = {
        id_supplier: this.id_supplier,
        supplier_name: value.supplier_name,
        supplier_address: value.supplier_address,
        supplier_phone_number: value.supplier_phone_number
      }

      await this.updateSupplier(payload)
    
      if (!this.supplierError) {
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


