<template>
  <div>
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
    <VForm>
      <VLayout>
        <VFlex sm6>
          <v-menu
          ref="menu1"
          v-model="menu1"
          :close-on-content-click="false"
          :nudge-right="40"
          lazy
          transition="scale-transition"
          offset-y
          full-width
          max-width="290px"
          min-width="290px"
        >
          <template v-slot:activator="{ on }">
            <v-text-field
              label="Tanggal"
              class="pa-1"
              v-model="form.date"
              :error-messages="dateErrors"
              @input="$v.form.date.$touch()"      
              required
              disabled
              v-on="on"
            ></v-text-field>
          </template>
          <v-date-picker v-model="form.date" @input="menu1 = false"></v-date-picker>
        </v-menu>
        </VFlex>
        <VFlex sm6>
          <v-select
            v-if="form.id_procurement==0"
            label="Status"
            class="pa-1"
            v-model="form.procurement_status"
            item-text="text"
            item-value="id"
            :items="status"
            :return-object="false"
            :error-messages="procurementStatusErrors"
            @input="$v.form.procurement_status.$touch()"
            @change="$v.form.procurement_status.$touch()"
            disabled
            required
          ></v-select>
          <v-select
            v-else
            label="Status"
            class="pa-1"
            v-model="form.procurement_status"
            item-text="text"
            item-value="id"
            :items="status"
            :return-object="false"
            :error-messages="procurementStatusErrors"
            @input="$v.form.procurement_status.$touch()"
            @change="$v.form.procurement_status.$touch()"
            disabled
            required
          ></v-select>
        </VFlex>
      </VLayout>
      <VLayout>
        <VFlex sm6>
          <v-select
            label="Supplier"
            class="pa-1"
            v-model="form.id_supplier"
            item-text="supplier_name"
            item-value="id_supplier"
            :items="suppliers"
            :return-object="false"
            :error-messages="supplierErrors"
            @input="$v.form.id_supplier.$touch()"
            @change="$v.form.id_supplier.$touch()"
            disabled
            required
          ></v-select>
        </VFlex>
        <VFlex sm6>
          <v-select
            label="Sales"
            class="pa-1"
            v-model="form.id_sales"
            item-text="sales_name"
            item-value="id_sales"
            :items="filtered"
            :return-object="false"
            :error-messages="salesErrors"
            @input="$v.form.id_sales.$touch()"
            @change="$v.form.id_sales.$touch()"
            disabled
            required
          ></v-select>
        </VFlex>
      </VLayout>
      <VAlert
        v-if="err"
        :value="true"
        dismissible
        type="error"
      >
        Data sudah terdapat pada list
      </VAlert>
      <VLayout>
        <VFlex sm12>
            <h2>Daftar Sparepart Datang</h2>
        </VFlex>
      </VLayout>
      <VAlert
        :value="true"
        dismissible
        type="info"
      >
        Verifikasi Data Sparepart dengan teliti!
      </VAlert>
      <VLayout>
        <VFlex class="text-md-center" sm12 mt-2>
          <VCard
            v-for="detail in form.detail"
            :key="detail.id_sparepart"
            color="#FAFAFA"
          >
              <v-card-title>
                <VLayout>
                    <VFlex sm3>
                        <v-select
                        label="Sparepart"
                        class="pa-1"
                        v-model="detail.id_sparepart"
                        item-text="sparepart_name"
                        item-value="id_sparepart"
                        :items="spareparts"
                        :return-object="false"
                        @change="getSelectedIndex()"
                        required
                    ></v-select>
                    </VFlex>
                    <VFlex sm3>
                        <VTextField
                        label="Jumlah"
                        class="pa-1"
                        v-model="detail.amount"
                        required
                        />
                    </VFlex>
                    <VFlex sm3>
                        <VTextField
                        label="Harga Beli"
                        class="pa-1"
                        v-model="detail.price"
                        required
                        />
                    </VFlex>
                    <VFlex sm3>
                        <VTextField
                        label="Harga Jual"
                        class="pa-1"
                        v-model="detail.sell_price"
                        required
                        />
                    </VFlex>
                </VLayout>
              </v-card-title>
          </VCard>
        </VFlex>
      </VLayout>
      <VLayout v-if="add">
        <VFlex class="text-md-center" sm12 mt-3>
            <VCard>
                <v-card-title>
                    <VFlex sm5>
                        <v-select
                        label="Sparepart"
                        class="pa-1"
                        v-model="sparepart.id_sparepart"
                        item-text="sparepart_name"
                        item-value="id_sparepart"
                        :items="spareparts"
                        :return-object="false"
                        @change="getSelectedIndex()"
                        required
                    ></v-select>
                    </VFlex>
                    <VFlex sm5>
                        <VTextField
                        label="Jumlah"
                        class="pa-1"
                        v-model="sparepart.amount"
                        required
                        />
                    </VFlex>
                    <VFlex class="text-xs-center" sm2>
                        <v-btn 
                            flat
                            icon
                            color="success"
                            dark
                            @click="compatibilityHandler()"
                        >
                            <v-icon>add_circle</v-icon>
                        </v-btn>
                        <VBtn
                        flat
                        icon
                        depressed
                        color="error"
                        @click="add=false"
                        >
                            <v-icon>remove_circle</v-icon>
                        </VBtn>
                    </VFlex>
                </v-card-title>
            </VCard>
        </VFlex>
      </VLayout>
      <VSpacer />
      <VLayout>
        <VFlex
          class="text-xs-center mt-3"
        >
          <VBtn
            depressed
            color="success"
            @click="submitHandler"
            :disabled="!this.value"
          >
            Kirim
          </VBtn>
        </VFlex>
      </VLayout>
    </VForm>
   </div>
</template>

<script>
import validator from '../../validations/procurementValidation'
import { mapGetters,mapState,mapActions } from 'vuex'

export default {
  props: {
    value: {
      type: Boolean,
      default: false
    }
  },
    data () {
    return {
      status: [
        { id: "Unprocessed", text: 'Unprocessed' },
        { id: "On Progress", text: 'On Progress' },
        { id: "Finish", text: 'Finish' }
      ],
      menu1: false,
      add: false,
      edit: false,
      sparepart:
      {
        id_sparepart: '',
        amount: 0,
        price: '',
        subtotal: ''
      },
      details: [],
      index: '',
      err: false
    }
  },

  computed: {
    ...mapGetters({
      form: 'Procurement/procurement'
    }),

    ...mapState({
      error: state => state.Procurement.error,
      loading: state => state.Procurement.loading,
      suppliers: state => state.Supplier.suppliers,
      sales: state => state.Sales.salesmany,
      spareparts: state => state.Sparepart.spareparts
    }),

    filtered(){
        let filter = this.sales.filter( b => b.id_supplier === this.form.id_supplier)
        return filter
    },

    dateErrors () {
      const errors = []

      if (!this.$v.form.date.$invalid) return errors
      
      if (!this.$v.form.date.required && this.$v.form.date.$dirty) {
        errors.push('Inputan tanggal tidak valid')
      }

      return errors
    },

    supplierErrors () {
      const errors = []

      if (!this.$v.form.id_supplier.$invalid) return errors 
      
      if (!this.$v.form.id_supplier.required && this.$v.form.id_supplier.$dirty) {
        errors.push('Anda belum memasukan supplier')
      }

      return errors
    },

    salesErrors () {
      const errors = []

      if (!this.$v.form.id_sales.$invalid) return errors 
      
      if (!this.$v.form.id_sales.required && this.$v.form.id_sales.$dirty) {
        errors.push('Anda belum memasukan sales')
      }

      return errors
    },

    procurementStatusErrors () {
      const errors = []

      if (!this.$v.form.procurement_status.$invalid) return errors 
      
      if (!this.$v.form.procurement_status.required && this.$v.form.procurement_status.$dirty) {
        errors.push('Anda belum memasukan sales')
      }

      return errors
    },

  },

  validations: validator,

  watch: {
    form: {
      deep: true,
      handler () {
        this.$emit('input', !this.$v.form.$invalid)
      }
    }    
  },

  methods: {
    ...mapActions({
      fetchSupplier: 'Supplier/get',
      fetchSales: 'Sales/get',
      fetchSparepart: 'Sparepart/get'
    }),

    deleteList(id)
    {
      let filter = this.form.detail.filter(function( obj ) {
          return obj.id_sparepart !== id;
      });
      this.form.detail=filter
    },

    getSelectedIndex(){
       this.index = this.spareparts.map(function(e) { return e.id_sparepart; }).indexOf(this.sparepart.id_sparepart);
       console.log(this.index)
    },

    compatibilityHandler () { 
      var i = 0
      this.err = false
      var object = this.sparepart
      for(var data in this.form.detail)
      {
          if(this.form.detail[i].id_sparepart==object.id_sparepart)
          {
              this.err = true
          }
          i++;
      }

      if(!this.err)
      {
        object.sparepart_name = this.spareparts[this.index].sparepart_name
        object.price = this.spareparts[this.index].purchase_price
        object.subtotal = object.amount*object.price
        this.form.detail.push(JSON.parse(JSON.stringify(object)))
        this.add = false
        this.sparepart.id_sparepart=""
        this.sparepart.amount=""
      }
      
    },

    submitHandler () {
      this.$emit('submitted', this.form)
    }
  },

  mounted () {
    this.fetchSupplier()
    this.fetchSales()
    this.fetchSparepart()
  }
}
</script>

<style scoped>
  .loading-section {
    text-align: center;
  }

  .list:hover {
    background: #def3bc;
    box-shadow: 0 0 11px rgba(33,33,33,.2); 
  }
</style>
