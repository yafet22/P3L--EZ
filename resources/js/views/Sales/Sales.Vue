<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
    <card>
      <v-container grid-list-md mb-0>
        <h1 class="text-md-center">DATA SALES</h1>
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
                Tambah Sales
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
      <SalesControl ref="salesControl">
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
              <td v-html="props.item.id_sales" />
              <td v-html="props.item.sales_name" />
              <td v-html="props.item.sales_phone_number" />
              <td v-html="props.item.supplier" />
              <td class="text-xs-center">
                <VBtn 
                  flat
                  icon
                  color="indigo"
                  dark
                  @click="editHandler(props.item.id_sales)"
                >
                  <v-icon>edit</v-icon>
                </VBtn>
                <VBtn 
                  flat
                  icon
                  color="error"
                  dark
                  @click="deletewarning(props.item.id_sales)"
                >
                  <v-icon>delete</v-icon>
                </VBtn>
              </td>
            </template>
          </VDataTable>
        </template>
      </SalesControl>
      <v-dialog v-model="dialog" max-width="600px">
        <UtilityCard title="Tambah Sales">
            <VCardText>
                <VAlert
                v-if="salesError"
                v-html="salesError.message"
                :value="true"
                dismissible
                type="error"
                />
                <SalesForm 
                v-model="isFormValid"
                @submitted="submitHandler"
                />
            </VCardText>
        </UtilityCard>
      </v-dialog>
      <v-dialog v-model="dialog2" max-width="600px">
        <UtilityCard title="Ubah Data Sales">
            <VCardText>
                <VAlert
                v-if="salesError"
                v-html="salesError.message"
                :value="true"
                dismissible
                type="error"
                />
                <SalesForm 
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
import SalesForm from '../../components/Form/SalesForm'
import SalesControl from '../../components/Renderless/SalesControl'
import salesService from '../../service/Sales'
import { mapActions,mapState } from 'vuex';

export default {
  components: {
    SalesControl,
    SalesForm
  },
  data () {
    return {
      name: '',
      isFormValid: false,
      dialog: false,
      dialog2: false,
      warning: false,
      keyword: '',
      id_sales: '',
      headers: [
          {
            text: 'ID',
            value: 'id_sales',
          },
          {
            text: 'Nama',
            value: 'sales_name'
          },
          {
            text: 'Nomor Telepon',
            value: 'sales_phone_number'
          },
          {
            text: 'Supplier',
            value: 'supplier'
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
          text: 'Sales',
          disabled: true,
        },
      ]
    }
  },

  computed: {
    ...mapState({
      salesError: state => state.Sales.error,
      salesLoading: state => state.Sales.loading
    })
  },


  methods: {
    ...mapActions({
      deleteSales: 'Sales/delete',
      storeSales: 'Sales/store',
      resetForm: 'Sales/resetForm',
      updateSales: 'Sales/update',
      fetchSales: 'Sales/edit',
    }),

    fetch () {
      this.$refs.salesControl.fetch()
    },

    editHandler(id){
      console.log(id)
      this.id_sales=id
      this.dialog2=true
    },

    deleteWarning(id){
        this.id_sales=id
        this.warning=true
    },

    async deleteHandler () {
      console.log(this.id_sales);
      await this.deleteSales(this.id_sales)
      this.fetch()
      this.warning=false
    },

    async submitHandler (value) {
      const payload = {
        sales_name: value.sales_name,
        id_supplier: value.id_supplier,
        sales_phone_number: value.sales_phone_number
      }

      await this.storeSales(payload)
    
      if (!this.salesError) {
        this.dialog=false
        this.fetch()
      }
    },

    async submitHandler2 (value) {
      
      console.log(this.id_sales);
      const payload = {
        id_sales: this.id_sales,
        sales_name: value.sales_name,
        id_supplier: value.id_supplier,
        sales_phone_number: value.sales_phone_number
      }

      await this.updateSales(payload)
    
      if (!this.salesError) {
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


