<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
    <card>
      <v-container grid-list-md mb-0>
        <h1 class="text-md-center">DATA TRANSAKSI</h1>
      </v-container> 
      <v-layout row wrap>
        <v-flex xs6>
            <VBtn
            depressed
            dark
            round
            color = "green accent-3"
            :to="{ name: 'transactions.create' }"
            >
            <VIcon>add</VIcon>
                Buat Transaksi Baru
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
      <TransactionControl ref="transactionControl">
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
              <td v-html="props.item.id_transaction" />
              <td v-html="props.item.customer_name" />
              <td v-html="props.item.transaction_date" />
              <td v-html="props.item.transaction_status" />
              <td class="text-xs-center">
                <VBtn 
                  flat
                  color="info"
                  @click="detailHandler(props.item.id_transaction)"
                >
                Detail
                </VBtn>
              </td>
              <td class="text-xs-center">
                <VBtn 
                  flat
                  color="warning"
                >
                Cetak
                </VBtn>
              </td>
              <td class="text-xs-center">
                <VBtn 
                  flat
                  icon
                  color="indigo"
                  dark
                  @click="editHandler(props.item.id_transaction)"
                >
                  <v-icon>edit</v-icon>
                </VBtn>
                <VBtn 
                  flat
                  icon
                  color="error"
                  dark
                  @click="deleteWarning(props.item.id_transaction)"
                >
                  <v-icon>delete</v-icon>
                </VBtn>
              </td>
            </template>
          </VDataTable>
        </template>
      </TransactionControl>
      <v-dialog v-model="warning" persistent max-width="500">
        <v-card>
            <v-card-title class="headline">Warning!</v-card-title>
            <VCardText
              v-if="loading || error"
              class="text-xs-center"
            >
              <VAlert
                v-if="error"
                :value="true"
                dismissible
                type="error"
              >
              {{ error.message }}
              </VAlert>
              <VProgressCircular
                v-if="loading"
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
import TransactionControl from '../../components/Renderless/TransactionControl'
import transactionService from '../../service/Transaction'
import { mapActions,mapState } from 'vuex';

export default {
  components: {
    TransactionControl
  },
  data () {
    return {
      name: '',
      isFormValid: false,
      dialog: false,
      dialog2: false,
      warning: false,
      dialog3: false,
      keyword: '',
      id_transaction: '',
      keyword2: '',
      headers: [
          {
            text: 'ID',
            value: 'id_transaction',
          },
          {
            text: 'Nama Pelanggan',
            value: 'customer_name'
          },
          {
            text: 'Tanggal',
            value: 'transaction_date'
          },
          {
            text: 'Status Transaksi',
            value: 'transaction_status'
          },
          {
            text: 'Detail Transaki',
            value: null
          },
          {
            text: 'SPK',
            value: null
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
          text: 'Transaksi',
          disabled: true,
        },
      ]
    }
  },

  computed: {
    ...mapState({
      transactionError: state => state.Transaction.error,
      transactionLoading: state => state.Transaction.loading,
    })
  },


  methods: {
    ...mapActions({
      deleteTransaction: 'Transaction/delete',
      storeTransaction: 'Transaction/store',
      resetForm: 'Transaction/resetForm',
      updateTransaction: 'Transaction/update',
      fetchTransaction: 'Transaction/edit'
    }),

    fetch () {
      this.$refs.transactionControl.fetch()
    },

    async detailHandler(id){
     
    },

    async editHandler(id){
      console.log(id)
      this.id_transaction=id
      await this.fetchTransaction(id)
      this.dialog2=true
    },

    deleteWarning(id){
        this.id_transaction=id
        this.warning=true
    },

    async deleteHandler () {
      console.log(this.id_transaction);
      await this.deleteTransaction(this.id_transaction)
      this.fetch()
      this.warning=false
    },

    async submitHandler (value) {
      const payload = {
        transaction_name: value.transaction_name,
        transaction_address: value.transaction_address,
        transaction_phone_number: value.transaction_phone_number
      }

      await this.storeTransaction(payload)
    
      if (!this.transactionError) {
        this.dialog=false
        this.fetch()
      }
    },

    async submitHandler2 (value) {
      
      console.log(this.id_transaction);
      const payload = {
        id_transaction: this.id_transaction,
      }

      await this.updateTransaction(payload)
    
      if (!this.transactionError) {
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


