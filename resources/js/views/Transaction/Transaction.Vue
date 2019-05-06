<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
    <card>
      <v-container grid-list-md mb-0>
        <h1 class="text-md-center">DATA TRANSAKSI</h1>
      </v-container> 
      <v-layout row wrap>
        <v-flex xs6>
            <VBtn
            v-if="role!='Cashier'"
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
            v-if="!loading && !error && role!='Cashier'"
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
                  @click="detailHandler(props.item)"
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
                  v-if="props.item.transaction_status=='finish'"
                  flat
                  icon
                  color="indigo"
                  :to="{ name: 'transactions.edit', params: { id: props.item.id_transaction }}"
                  disabled
                >
                  <v-icon>edit</v-icon>
                </VBtn>
                <VBtn 
                  v-else
                  flat
                  icon
                  color="indigo"
                  dark
                  :to="{ name: 'transactions.edit', params: { id: props.item.id_transaction }}"
                >
                  <v-icon>edit</v-icon>
                </VBtn>
                <VBtn 
                  v-if="props.item.transaction_status=='finish'"
                  flat
                  icon
                  color="error"
                  
                  @click="deleteWarning(props.item.id_transaction)"
                  disabled
                >
                  <v-icon>delete</v-icon>
                </VBtn>
                <VBtn 
                  v-else
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
          <VDataTable
            :headers="headers4"
            :items="items"
            :search="keyword"
            v-else-if="!loading && !error"
          >
            <template slot="items" slot-scope="props">
              <td v-html="props.item.id_transaction" />
              <td v-html="props.item.customer_name" />
              <td v-html="props.item.transaction_date" />
              <td v-html="props.item.transaction_status" />
              <td v-html="props.item.transaction_paid" />
              <td class="text-xs-center">
                <VBtn 
                  v-if="props.item.transaction_paid=='unpaid' && props.item.transaction_status=='finish'"
                  flat
                  color="info"
                  @click="detailHandler(props.item)"
                >
                Bayar
                </VBtn>
                <VBtn 
                  v-else
                  disabled
                  flat
                  color="info"
                  @click="detailHandler(props.item)"
                >
                Bayar
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
            </template>
          </VDataTable>
        </template>
      </TransactionControl>
      <v-dialog v-model="dialog" max-width="800px">
        <UtilityCard title="Detail Transaksi">
            <VCardText>
              <VLayout>
                <VFlex sm6 class="text-md-left">
                  {{ transaction.id_transaction }}
                </VFlex>
                <VFlex sm6 class="text-md-right">
                  {{ transaction.transaction_date }}
                </VFlex>
              </VLayout>
              <VLayout>
                <VFlex sm6 class="text-md-left">
                  Cost : {{ transaction.customer_name}}
                </VFlex>
                <VFlex sm6 class="text-md-right">
                  Cs : 
                  {{ cs.name }}
                </VFlex>
              </VLayout>
              <VLayout>
                <VFlex sm6 class="text-md-left">
                  Telepon : {{ transaction.customer_name}}
                </VFlex>
                <VFlex sm6 class="text-md-right">
                  <VLayout>
                    <VFlex sm10 class="text-md-right">
                         Montir : 
                    </VFlex>
                    <VFlex sm2 class="text-md-right">
                        <li style="list-style: none;" v-for="mechanic in mechanics" :key="mechanic">
                          {{ mechanic }}
                        </li>
                    </VFlex>
                  </VLayout>
                </VFlex>
              </VLayout>
              <VLayout v-if="spareparts.length!=0">
                  <VFlex sm12 class="text-md-center">
                      <h2>DATA SPAREPART</h2>
                  </VFlex>        
              </VLayout>
              <VLayout v-if="spareparts.length!=0">
                <VFlex sm12>
                  <VDataTable
                    :headers="headers2"
                    :items="spareparts"
                    :search="keyword"
                    hide-actions
                    v-if="!loading && !error"
                  >
                    <template slot="items" slot-scope="props">
                      <td v-html="props.item.id_sparepart" />
                      <td v-html="props.item.sparepart_name" />
                      <td v-html="props.item.merk" />
                      <td v-html="props.item.detail_sparepart_price" />
                      <td v-html="props.item.detail_sparepart_amount" />
                      <td v-html="props.item.detail_sparepart_subtotal" />
                    </template>
                    <template v-slot:footer>
                      <td :colspan="headers.length" class="text-md-right">
                        Total Sparepart : Rp  {{ totalSparepart }}
                      </td>
                    </template>
                  </VDataTable>
                </VFlex>
              </VLayout>
              <VLayout v-if="services.length!=0">
                  <VFlex sm12 class="text-md-center">
                      <h2>DATA SERVICE</h2>
                  </VFlex>        
              </VLayout>
              <VLayout v-if="services.length!=0">
                <VFlex sm12>
                  <VDataTable
                    :headers="headers3"
                    :items="services"
                    :search="keyword"
                    hide-actions
                    v-if="!loading && !error"
                  >
                    <template slot="items" slot-scope="props">
                      <td v-html="props.item.id_service" />
                      <td v-html="props.item.service_name" />
                      <td v-html="props.item.detail_service_price" />
                      <td v-html="props.item.detail_service_amount" />
                      <td v-html="props.item.detail_service_subtotal" />
                    </template>
                    <template v-slot:footer>
                      <td :colspan="headers.length" class="text-md-right">
                        Total Service : Rp  {{ totalService }}
                      </td>
                    </template>
                  </VDataTable>
                </VFlex>
              </VLayout>
              <VLayout v-if="role=='Cashier'">
                  <VFlex sm12 class="text-md-center">
                      <h2>PEMBAYARAN</h2>
                  </VFlex>        
              </VLayout>
               <VLayout v-if="role=='Cashier'">
                <VFlex >
                   <strong> Total :  Rp {{ this.payment.total }} </strong>
                </VFlex>
              </VLayout>
              <VLayout v-if="role=='Cashier'">
                <VFlex >
                   <strong> Diskon : Rp {{ this.payment.discount }} </strong>
                </VFlex>
              </VLayout>
              <VLayout v-if="role=='Cashier'">
                <VFlex >
                   <strong> Jumlah Bayar : Rp {{ this.payment.payamount }} </strong>
                </VFlex>
              </VLayout>
              <VLayout v-if="role=='Cashier'">
                <VFlex >
                   <strong> Kembalian : Rp {{ this.payment.change }} </strong>
                </VFlex>
              </VLayout>
              <VLayout v-if="role=='Cashier'" class="mt-2">
                <VFlex sm6>
                    <VTextField
                      label="Diskon"
                      class="pa-1"
                      v-model="payment.discount"
                      required
                      @change="calculateDiscount(),$v.form.discount.$touch()"
                      :error-messages="discountErrors"
                      @blur="$v.form.discount.$touch()"
                    />
                </VFlex>
                <VFlex sm6>
                    <VTextField
                      label="Jumlah Bayar"
                      class="pa-1"
                      v-model="payment.payamount"
                      required
                      @change="calculateChange()"
                      :error-messages="payamountErrors"
                      @input="$v.form.payamount.$touch()"
                    />
                </VFlex>
              </VLayout>
              <VSpacer />
              <VLayout v-if="role=='Cashier'">
                <VFlex
                  class="text-xs-center"
                >
                  <VBtn
                    depressed
                    color="success"
                    @click="paymentProcess()"
                  >
                    Konfirmasi Pembayarann
                  </VBtn>
                </VFlex>
              </VLayout>
            </VCardText>
        </UtilityCard>
      </v-dialog>
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
      <v-dialog v-model="success" persistent max-width="500">
        <v-card>
            <v-card-text class="text-md-center" style="font-size:15px">Pembayaran Berhasil</v-card-text>
            <v-card-actions>
            <v-spacer/>
            <VBtn class="mb-4" depressed dark color="green accent-3" @click="success=false">Ok</VBtn>
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
import { required, maxLength, numeric, sameAs, not} from 'vuelidate/lib/validators'
import { mapActions,mapState,mapGetters } from 'vuex'

function payMinimal(){
  if(this.payment.payamount<this.payment.total)
  {
      return false
  }
  return true
}

export default {
  components: {
    TransactionControl
  },
  validations: {
    payment : {
      payamount: { required,payMinimal,numeric },
      discount: { numeric }
    }
  },
  data () {
    return {
      name: '',
      success: false,
      dialog: false,
      isFormValid: false,
      dialog: false,
      dialog2: false,
      warning: false,
      dialog3: false,
      totalSparepart: 0,
      totalService: 0,
      transaction: [],
      cs: [],
      employees: [],
      spareparts: [],
      services: [],
      mechanics: [],
      payment:
      {
        id_transaction: '',
        total: 0,
        change: 0,
        discount: 0,
        payamount: 0
      },
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
      headers2: [
          {
            text: 'kode',
            value: 'id_sparepart',
          },
          {
            text: 'Nama',
            value: 'sparepart_name'
          },
          {
            text: 'Merk',
            value: 'merk'
          },
          {
            text: 'Harga',
            value: 'detail_sparepart_price'
          },
          {
            text: 'Jumlah',
            value: 'detail_sparepart_amount'
          },
          {
            text: 'Subtotal',
            value: 'detail_sparepart_subtotal'
          },
      ],
      headers3: [
          {
            text: 'ID Service',
            value: 'id_service',
          },
          {
            text: 'Type',
            value: 'service_name'
          },
          {
            text: 'Harga',
            value: 'detail_service_price'
          },
          {
            text: 'Jumlah',
            value: 'detail_service_amount'
          },
          {
            text: 'Subtotal',
            value: 'detail_service_subtotal'
          },
      ],
      headers4: [
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
            text: 'Status Bayar',
            value: 'transaction_paid'
          },
          {
            text: 'Pembayaran',
            value: null
          },
          {
            text: 'Cetak Nota',
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
    }),
    ...mapGetters({
        role: 'LoggedUser/role',
    }),
    payamountErrors () {
      const errors = []

      if (!this.$v.payment.payamount.$dirty) return errors 

      !this.$v.payment.payamount.numeric && errors.push('Inputan total tidak valid')
     

      !this.$v.payment.payamount.payMinimal && errors.push('Pembayaran harus melebihi total harga')

      return errors
    },
    discountErrors () {
      const errors = []

      if (!this.$v.payment.discount.$dirty) return errors 

      !this.$v.payment.discount.numeric && errors.push('Inputan diskon tidak valid')
     
      return errors
    },
  },


  methods: {
    ...mapActions({
      deleteTransaction: 'Transaction/delete',
      storeTransaction: 'Transaction/store',
      resetForm: 'Transaction/resetForm',
      updateTransaction: 'Transaction/update',
      fetchTransaction: 'Transaction/edit',
      paymentTransaction: 'Transaction/payment'
    }),

    fetch () {
      this.$refs.transactionControl.fetch()
    },

    detailHandler(transaction){
      this.payment.id_transaction=transaction.id_transaction
      this.mechanics=[]
      this.totalService=0
      this.totalSparepart=0
      console.log("cek")
      this.transaction=transaction
      this.employees=transaction.employee.data
      this.spareparts=transaction.sparepart.data
      this.services=transaction.service.data
      this.employees.forEach(employee => {
          if(employee.id_role==2 || employee.id_role==1)
          {
              this.cs=employee
          }
      });
      this.spareparts.forEach(sparepart => {
        this.totalSparepart=this.totalSparepart+sparepart.detail_sparepart_subtotal
        console.log(sparepart.mechanic_name)
        if(this.mechanics.length==0)
        {
          this.mechanics.push(sparepart.mechanic_name)
        }  
        else
        {   
          this.mechanics.forEach(mechanic => {
              console.log(mechanic)
              if(sparepart.mechanic_name!=mechanic)
              {
                  console.log("coba")
                  this.mechanics.push(sparepart.mechanic_name)
              }
          });
        }

      });
      this.services.forEach(service => {
          this.totalService=this.totalService+service.detail_service_subtotal
          if(this.mechanics.length==0)
          {
            this.mechanics.push(service.mechanic_name)
          }  
          else
          {
            this.mechanics.forEach(mechanic => {
                console.log(mechanic)
                console.log("cekcek")
                if(service.mechanic_name!=mechanic)
                {
                    console.log("coba2")
                    this.mechanics.push(service.mechanic_name)
                }
            });
          }
      });
      this.payment.total=this.totalService+this.totalSparepart
      this.dialog=true
    },

    // async editHandler(id){
    //   console.log(id)
    //   this.id_transaction=id
    //   await this.fetchTransaction(id)
    //   this.dialog2=true
    // },

    deleteWarning(id){
        this.id_transaction=id
        this.warning=true
    },

    calculateDiscount(){
      this.payment.total=this.totalService+this.totalSparepart
      this.payment.total=this.payment.total-this.payment.discount
    },

    calculateChange(){
      this.payment.change=this.payment.payamount-this.payment.total
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

    async paymentProcess(){
      await this.paymentTransaction(this.payment)

      if (!this.transactionError) {
        this.dialog=false
        this.fetch()
        this.success=true
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


