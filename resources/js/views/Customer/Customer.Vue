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
                  color="info"
                  @click="motorHandler(props.item.id_customer)"
                >
                List Motor
                </VBtn>
              </td>
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
      <v-dialog v-model="dialog3" :max-width="1200" :width="1200">
        <UtilityCard title="List Motor">
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
            <VCardText>
                <v-layout row wrap>
                  <v-flex xs6>
                      
                  </v-flex>
                  <v-flex xs6 class="text-xs-right">
                      <CardSearchBar v-model="keyword2" />
                  </v-flex>
                </v-layout>
                <VDataTable
                  :headers="headers2"
                  :items="motorcycle"
                  :search="keyword2"
                >
                  <template slot="items" slot-scope="props">
                    <td v-html="props.item.id_motorcycle"/>
                    <td v-html="props.item.license_number" v-if="!props.item.edit" />
                    <td v-else> 
                      <v-text-field
                        v-model="form.license_number"
                        label="Edit"
                        single-line
                        counter
                        :error-messages="licenseNumberErrors"
                        @input="$v.form.license_number.$touch()"
                        required
                      ></v-text-field>
                    </td>             
                    <td v-html="props.item.motorcycle_brand" v-if="!props.item.edit"/> 
                    <td v-else> 
                      <v-select
                        label="merk motor"
                        @change="$v.form.id_motorcycle_brand.$touch()"
                        v-model="form.id_motorcycle_brand"
                        item-text="motorcycle_brand_name"
                        item-value="id_motorcycle_brand"
                        :items="brand"
                        single-line
                        counter
                        :error-messages="motorcycleBrandErrors"
                        @input="$v.form.id_motorcycle_brand.$touch()"
                        required
                      ></v-select>
                    </td>                       
                    <td v-html="props.item.motorcycle_type" v-if="!props.item.edit"/>
                    <td v-else> 
                      <v-select
                        label="merk motor"
                        v-model="form.id_motorcycle_type"
                        item-text="motorcycle_type_name"
                        item-value="id_motorcycle_type"
                        :items="filtered"
                        single-line
                        counter
                        :error-messages="motorcycleTypeErrors"
                        @input="$v.form.id_motorcycle_type.$touch()"
                        required
                      ></v-select>
                    </td>        
                    <td class="text-xs-center" v-if="!props.item.edit">
                      <VBtn 
                        flat
                        icon
                        color="indigo"
                        dark
                        @click="props.item.edit=true,bindData(props.item),filterType(props.item.id_motorcycle_brand)"
                        :disabled="value"
                      >
                        <v-icon>edit</v-icon>
                      </VBtn>
                      <VBtn 
                        flat
                        icon
                        color="error"
                        dark
                        @click="deleteWarning2(props.item.id_motorcycle)"
                      >
                        <v-icon>delete</v-icon>
                      </VBtn>
                    </td>
                    <td class="text-xs-center" v-else>
                       <VBtn
                        flat
                        icon
                        depressed
                        color="success"
                        @click="editMotor(props.item.id_motorcycle,form),props.item.edit=false"
                      >
                        <v-icon>check_circle</v-icon>
                      </VBtn>
                      <VBtn
                        flat
                        icon
                        depressed
                        color="error"
                        @click="props.item.edit=false"
                      >
                        <v-icon>remove_circle</v-icon>
                      </VBtn>
                    </td>
                  </template>
                  <template v-slot:footer>
                    <td :colspan="headers.length" v-if="add">
                      <MotorcycleForm 
                        class="mt-2"
                        v-model="isFormValid2"
                        @submitted="submitMotor" 
                        @canceled="cancelSubmit" 
                        />
                    </td>
                    <td style="text-align:right;" :colspan="headers.length" v-if="hide" >
                      <VBtn
                        flat
                        icon
                        depressed
                        color="success"
                        @click="addHandler()"
                      >
                        <v-icon>add_circle</v-icon>
                      </VBtn>
                    </td>
                  </template>
                </VDataTable>
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
      <v-dialog v-model="warning2" persistent :width="500">
        <v-card>
            <v-card-title class="headline">Warning!</v-card-title>
            <VCardText
              v-if="customerLoading || customerError"
              class="text-xs-center"
            >
              <VAlert
                v-if="customerError"
                :value="true"
                dismissible
                type="error"
              >
              {{ customerError.message }}
              </VAlert>
              <VProgressCircular
                v-if="customerLoading"
                :size="45"
                indeterminate
                class="loading-section"
              />
            </VCardText>
            <v-card-text v-else class="text-md-center" style="font-size:15px">Anda yakin ingin menghapus data ini?</v-card-text>
            <v-card-actions>
            <v-spacer/>
            <VBtn class="mb-4" depressed dark color="red accent-3" @click="warning2 = false">Disagree</VBtn>
            <VBtn class="mb-4" depressed dark color="green accent-3" @click="deleteHandler2()">Agree</VBtn>
            <v-spacer/>
            </v-card-actions>
        </v-card>
      </v-dialog>
    </card>
  </PageWrapper>
</template>

<script>
import validator from '../../validations/motorcycleValidation'
import MotorcycleForm from '../../components/Form/MotorcycleForm'
import CustomerForm from '../../components/Form/CustomerForm'
import CustomerControl from '../../components/Renderless/CustomerControl'
import customerService from '../../service/Customer'
import { mapActions,mapState,mapGetters } from 'vuex';

export default {
  components: {
    CustomerControl,
    CustomerForm,
    MotorcycleForm
  },
  data () {
    return {
      add: false,
      hide: true,
      value: false,
      name: '',
      edit: false,
      isFormValid: false,
      isFormValid2: false,
      dialog: false,
      dialog2: false,
      dialog3: false,
      warning: false,
      warning2: false,
      keyword: '',
      keyword2: '',
      id_customer: '',
      license_number: '',
      id_motorcycle_brand: '',
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
            text: 'Motor',
            value: null
          },
          {
            text: 'Aksi',
            value: null
          },
      ],
      headers2: [
          {
            text: 'ID',
            value: 'id_motorcycle',
          },
          {
            text: 'Nomor Polisi',
            value: 'license_number'
          },
          {
            text: 'Merk Motor',
            value: 'motorcycle_brand'
          },
          {
            text: 'Type Motor',
            value: 'motorcycle_type'
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
      customerLoading: state => state.Customer.loading,
      motorcycle: state=> state.Motorcycle.motorcycles,
      motorError: state => state.Motorcycle.error,
      brand: state => state.MotorcycleBrand.motorcycleBrands,
      type: state => state.MotorcycleType.motorcycleTypes,
    }),
    ...mapGetters({
      form: 'Motorcycle/motorcycle',
      user: 'Customer/customer'
    }),

    filtered(){
        let filter = this.type.filter( b => b.id_motorcycle_brand === this.form.id_motorcycle_brand)
        return filter
    },

    licenseNumberErrors () {
      const errors = []

      if (!this.$v.form.license_number.$invalid) return errors

      if (!this.$v.form.license_number.maxLength && this.$v.form.license_number.$dirty) {
        errors.push('Nomor Polisi Melebihi karakter yang ditentukan')
      }
      
      if (!this.$v.form.license_number.required && this.$v.form.license_number.$dirty) {
        errors.push('Inputan nama tidak valid')
      }

      return errors
    },

    motorcycleBrandErrors() {
      const errors = []

      if (!this.$v.form.id_motorcycle_brand.$invalid) return errors
      
      if (!this.$v.form.id_motorcycle_brand.required && this.$v.form.id_motorcycle_brand.$dirty) {
        errors.push('Inputan nama tidak valid')
      }

      return errors
    },

    motorcycleTypeErrors() {
      const errors = []

      if (!this.$v.form.id_motorcycle_type.$invalid) return errors
      
      if (!this.$v.form.id_motorcycle_type.required && this.$v.form.id_motorcycle_type.$dirty) {
        errors.push('Inputan nama tidak valid')
      }

      return errors
    },
  },

  validations: validator,

  watch: {
    form: {
      deep: true,
      handler () {
        !this.$v.form.$invalid
      }
    }    
  },


  methods: {
    ...mapActions({
      deleteCustomer: 'Customer/delete',
      storeCustomer: 'Customer/store',
      resetForm: 'Customer/resetForm',
      updateCustomer: 'Customer/update',
      fetchCustomer: 'Customer/edit',
      findMotor: 'Motorcycle/findByUser',
      storeMotor: 'Motorcycle/store',
      deleteMotor: 'Motorcycle/delete',
      fetchMotor: 'Motorcycle/edit',
      updateMotor: 'Motorcycle/update',
      getBrand: 'MotorcycleBrand/get',
      getType: 'MotorcycleType/get'
    }),

    fetch () {
      this.$refs.customerControl.fetch()
    },

    addHandler(){
      this.add=true
      this.hide=false
    },

    cancelSubmit(){
      this.add=false
      this.hide=true
    },

    async editHandler(id){
      this.id_customer=id
      await this.fetchCustomer(id)
      this.dialog2=true
    },

    async motorHandler(id){
      await this.findMotor(id)
      this.id_customer=id
      this.dialog3=true
    },

    deleteWarning(id){
        this.id_customer=id
        this.warning=true
    },

    filterType(id){
      console.log(id)
      this.id_motorcycle_brand=id
    },

    bindData(item){
        this.form.license_number=item.license_number
        this.form.id_motorcycle_brand=item.id_motorcycle_brand
        this.form.id_motorcycle_type=item.id_motorcycle_type
    },

    async editMotor(id,item){
      const payload = {
        id_motorcycle: id,
        license_number: item.license_number,
        id_motorcycle_type: item.id_motorcycle_type,
        id_customer: this.id_customer
      }

      console.log(payload)

      this.id_motorcycle_brand=item.id_motorcycle_brand
      await this.updateMotor(payload)
    
      if (!this.motorError) {
        await this.findMotor(this.id_customer)
      }
    },

    deleteWarning2(id){
        this.id_motorcycle=id
        this.warning2=true
    },

    async deleteHandler () {
      console.log(this.id_customer);
      await this.deleteCustomer(this.id_customer)
      this.fetch()
      this.warning=false
    },

    async deleteHandler2 () {
      console.log(this.id_customer);
      await this.deleteMotor(this.id_motorcycle)
      await this.findMotor(this.id_customer)
      this.warning2=false
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

    async submitMotor (value) {
      const payload = {
        license_number: value.license_number,
        id_motorcycle_type: value.id_motorcycle_type,
        id_customer: this.id_customer
      }

      await this.storeMotor(payload)
    
      if (!this.motorError) {
        this.add=false
        this.hide=true
        await this.findMotor(this.id_customer)
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
    this.getBrand()
    this.getType()
  }
}
</script>

<style scoped>
.loading-section {
  text-align: center;
}
</style>


