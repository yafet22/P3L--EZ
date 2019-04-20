<template>
 <PageWrapper :breadcrumbs="breadcrumbs">
    <card>
     <v-layout row wrap>
        <v-flex sm6>
         <v-card>
            <v-card-title primary-title class="justify-center">
                <div class="headline">DATA PELANGGAN</div>
            </v-card-title>
            <v-card-text>
                <v-switch
                v-model="switchnewcustomer"
                label="Pelanggan baru"
                @change="resetcustomer"
                ></v-switch>
                <v-form>
                    <VLayout>
                        <VFlex>
                        <VProgressLinear 
                            v-if="customerloading"
                            indeterminate
                        />
                        <v-autocomplete
                            v-if="!switchnewcustomer"
                            v-model="customer.id_customer"
                            :items="customers"
                            item-text="customer_name"
                            item-value="id_customer"
                            class="pa-1"
                            label="Nama"
                            @change="searchcustomer()"
                        ></v-autocomplete>
                        <VTextField
                            v-else
                            label="Nama"
                            class="pa-1"
                            v-model="customer.customer_name"
                            required
                        />
                        </VFlex>
                    </VLayout>
                    <VLayout>
                        <VFlex>
                        <VTextField
                            label="Alamat"
                            class="pa-1"
                            v-model="customer.customer_address"
                            :disabled="!switchnewcustomer"
                            required
                        />
                        </VFlex>
                    </VLayout>
                    <VLayout>
                        <VFlex>
                        <VTextField
                            label="No Telepon"
                            class="pa-1"
                            v-model="customer.customer_phone_number"
                            :disabled="!switchnewcustomer"
                            required
                        />
                        </VFlex>
                    </VLayout>
                </v-form>
            </v-card-text>
         </v-card>
        </v-flex>
        <v-flex sm6>
         <v-card>
         <v-layout row wrap>
             <v-flex sm12>
                <v-card-title primary-title class="justify-center">
                    <div class="headline">JENIS TRANSAKSI</div>
                </v-card-title>
                <v-card-text>
                    <VLayout>
                        <VFlex>
                         <v-radio-group v-model="transaction.transaction_type" class="justify-center" row>
                         <v-radio label="Sparepart" value="Sparepart"></v-radio>
                         <v-radio label="Service And Sparepart" value="Service And Sparepart"></v-radio>
                         <v-radio label="Service" value="Service"></v-radio>
                         </v-radio-group>
                        </VFlex>
                    </VLayout>
                </v-card-text>
                <br>
                <hr>

                <v-card-title primary-title class="justify-center">
                    <div class="headline">STATUS TRANSAKSI</div>
                </v-card-title>
                <v-card-text>
                    <VLayout>
                        <VFlex>
                         <v-select
                            label="Status Transaksi"
                            class="pa-1"
                            v-model="transaction.transaction_status"
                            item-text="text"
                            item-value="id"
                            :items="status"
                            :return-object="false"
                            required
                        ></v-select>
                        </VFlex>
                    </VLayout>
                </v-card-text>
             </v-flex>
         </v-layout> 
         </v-card>
        </v-flex>
     </v-layout>
     <v-layout row wrap mt-1>
         <v-flex sm12 v-if="!switchnewcustomer">
           <v-card>
            <v-card-title primary-title class="justify-center">
                <div class="headline">DAFTAR MOTOR PELANGGAN</div>
            </v-card-title>
            <v-card-text>
                <VDataTable
                  :headers="headers"
                  :items="motorcycles"
                  :search="keyword"
                >
                  <template slot="items" slot-scope="props">
                    <td v-html="props.item.id_motorcycle"/>
                    <td v-html="props.item.license_number" v-if="!props.item.edit" />
                    <td v-else> 
                      <v-text-field
                        v-model="motorcycle.license_number"
                        label="Edit"
                        single-line
                        counter
                        required
                      ></v-text-field>
                    </td>             
                    <td v-html="props.item.motorcycle_brand" v-if="!props.item.edit"/> 
                    <td v-else> 
                      <v-select
                        label="merk motor"
                        v-model="motorcycle.id_motorcycle_brand"
                        item-text="motorcycle_brand_name"
                        item-value="id_motorcycle_brand"
                        :items="brand"
                        single-line
                        counter
                        required
                      ></v-select>
                    </td>                       
                    <td v-html="props.item.motorcycle_type" v-if="!props.item.edit"/>
                    <td v-else> 
                      <v-select
                        label="merk motor"
                        v-model="motorcycle.id_motorcycle_type"
                        item-text="motorcycle_type_name"
                        item-value="id_motorcycle_type"
                        :items="filtered"
                        single-line
                        counter
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
                        @click="editMotor(props.item.id_motorcycle,motorcycle),props.item.edit=false"
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
            </v-card-text>
         </v-card>  
         </v-flex>
     </v-layout>
     <v-layout row wrap mt-1 v-if="transaction.transaction_type=='Service'">
         <v-flex sm12 >
           <v-card>
            <v-card-title primary-title class="justify-center">
                <div class="headline">JASA SERVICE</div>
            </v-card-title>
            <v-card-text>
                <VAlert
                    v-if="err"
                    :value="true"
                    dismissible
                    type="error"
                >
                Transaki yang sama telah dilakukan
                </VAlert>
                <VDataTable
                  :headers="headers2"
                  :items="transaction.service"
                  :search="keyword"
                >
                  <template slot="items" slot-scope="props">
                    <td v-html="props.item.service_name"/>
                    <td v-html="props.item.license_number" />         
                    <td v-html="props.item.mechanic_name" />                      
                    <td v-html="props.item.detail_service_price" />     
                    <td class="text-xs-center">
                      <VBtn 
                        flat
                        icon
                        color="indigo"
                        dark
                      >
                        <v-icon>edit</v-icon>
                      </VBtn>
                      <VBtn 
                        flat
                        icon
                        color="error"
                      >
                        <v-icon>delete</v-icon>
                      </VBtn>
                    </td>
                  </template>
                  <template v-slot:footer>
                    <td :colspan="headers.length" v-if="add2">
                      <v-form class="mt-2">
                        <VLayout>
                            <VFlex sm3>
                            <v-select
                                label="Tipe Service"
                                class="pa-1"
                                v-model="service.id_service"
                                item-text="service_name"
                                item-value="id_service"
                                :items="services"
                                :return-object="false"
                                required
                            ></v-select>
                            </VFlex>
                            <VFlex sm3>
                            <v-select
                                label="Motor Pelanggan"
                                class="pa-1"
                                v-model="service.id_motorcycle"
                                item-text="license_number"
                                item-value="id_motorcycle"
                                :items="motorcycles"
                                :return-object="false"
                                required
                            ></v-select>
                            </VFlex>
                            <VFlex sm3>
                            <v-select
                                label="Montir"
                                class="pa-1"
                                v-model="service.id_employee"
                                item-text="name"
                                item-value="id_employee"
                                :items="mechanic"
                                :return-object="false"
                                required
                            ></v-select>
                            </VFlex>
                            <VFlex sm3
                            class="text-xs-center"
                            >
                            <VBtn
                                flat
                                icon
                                depressed
                                color="success"
                                @click="submitService"
                            >
                                <v-icon>check_box</v-icon>
                            </VBtn>
                            <VBtn
                                flat
                                icon
                                depressed
                                @click="cancelSubmit2"
                                color="error"
                            >
                                <v-icon>remove_circle</v-icon>
                            </VBtn>
                            </VFlex>
                        </VLayout>
                    </v-form>
                    </td>
                    <td style="text-align:right;" :colspan="headers.length" v-if="hide2" >
                      <VBtn
                        flat
                        icon
                        depressed
                        color="success"
                        @click="addHandler2()"
                      >
                        <v-icon>add_circle</v-icon>
                      </VBtn>
                    </td>
                  </template>
                </VDataTable>
            </v-card-text>
         </v-card>  
         </v-flex>
     </v-layout>
     <v-layout row wrap mt-1 v-else-if="transaction.transaction_type=='Sparepart'">
         <v-flex sm12 >
           <v-card>
            <v-card-title primary-title class="justify-center">
                <div class="headline">DAFTAR SPAREPART</div>
            </v-card-title>
            <v-card-text>
                
            </v-card-text>
         </v-card>  
         </v-flex>
     </v-layout>
     <v-layout row wrap mt-1 v-if="transaction.transaction_type=='Service And Sparepart'">
         <v-flex sm12 >
           <v-card>
            <v-card-title primary-title class="justify-center">
                <div class="headline">JASA SERVICE</div>
            </v-card-title>
            <v-card-text>
                
            </v-card-text>
         </v-card>  
         </v-flex>
     </v-layout>
     <v-layout row wrap mt-1 v-if="transaction.transaction_type=='Service And Sparepart'">
         <v-flex sm12 >
           <v-card>
            <v-card-title primary-title class="justify-center">
                <div class="headline">DAFTAR SPAREPART</div>
            </v-card-title>
            <v-card-text>
                
            </v-card-text>
         </v-card>  
         </v-flex>
     </v-layout>
     <v-dialog v-model="warning2" persistent :width="500">
        <v-card>
            <v-card-title class="headline">Warning!</v-card-title>
            <v-card-text class="text-md-center" style="font-size:15px">Anda yakin ingin menghapus data ini?</v-card-text>
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
import MotorcycleForm from '../../components/Form/MotorcycleForm'
import { mapGetters,mapState, mapActions } from 'vuex';

export default {
  components: {
      MotorcycleForm
  },
  data () {
    return {
      isFormValid2: "",
      add: false,
      hide: true,
      add2: false,
      hide2: true,
      value2: false,
      value: false,
      edit: false,
      switchnewcustomer: false,
      row: null,
      err: false,
      keyword: "",
      id_motorcycle: "",
      warning2: "",
      status: [
        { id: "unprocessed", text: 'unprocessed' },
        { id: "on progress", text: 'on progress' },
        { id: "finish", text: 'finish' }
      ],
      service: {
          id_service: "",
          service_name: "",
          id_employee: "",
          mechanic_name: "",
          id_motorcycle: "",
          license_number: "",
          detail_service_price: ""
      },
      headers: [
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
      headers2: [
          {
            text: 'Type Service',
            value: 'service_name'
          },
          {
            text: 'Motor Pelanggan',
            value: 'license_number'
          },
          {
            text: 'Montir',
            value: 'mechanic_name'
          },
          {
            text: 'Harga Satuan',
            value: 'detail_service_price'
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
          to: { name: 'transactions' },
          exact: true,
        },
        {
          text: 'Buat Transaksi',
          disabled: true,
        },
      ]
    }
  },
  computed: {
    ...mapGetters({
        customer: 'Customer/customer',
        transaction: 'Transaction/transaction',
        motorcycle: 'Motorcycle/motorcycle',
        serviceData: 'Service/service',
        employee: 'Employee/employee'
    }),

    ...mapState({
        customers: state => state.Customer.customers,
        customerloading: state => state.Customer.loading,
        motorcycles: state => state.Motorcycle.motorcycles, 
        motorError: state => state.Motorcycle.error,       
        brand: state => state.MotorcycleBrand.motorcycleBrands,
        type: state => state.MotorcycleType.motorcycleTypes,
        services: state => state.Service.services,
        employees: state => state.Employee.employees
    }),

    filtered(){
        let filter = this.type.filter( b => b.id_motorcycle_brand === this.motorcycle.id_motorcycle_brand)
        return filter
    },

    mechanic(){
        let filter = this.employees.filter( b => b.role === "Mechanic")
        return filter
    },
  },  

  methods: {
    ...mapActions({
      fetchCustomer: 'Customer/get',
      findCustomer: 'Customer/edit',
      findMotor: 'Motorcycle/findByUser',
      storeMotor: 'Motorcycle/store',
      deleteMotor: 'Motorcycle/delete',
      fetchMotor: 'Motorcycle/edit',
      updateMotor: 'Motorcycle/update',
      getBrand: 'MotorcycleBrand/get',
      getType: 'MotorcycleType/get',
      resetMotor: 'Motorcycle/resetForm',
      getService: 'Service/get',
      getEmployee: 'Employee/get',
      findService: 'Service/edit',
      findEmployee: 'Employee/edit',
    }),
    async editMotor(id,item){
      const payload = {
        id_motorcycle: id,
        license_number: item.license_number,
        id_motorcycle_type: item.id_motorcycle_type,
        id_customer: this.customer.id_customer
      }

      console.log(payload)

      this.id_motorcycle_brand=item.id_motorcycle_brand
      await this.updateMotor(payload)
    
      if (!this.motorError) {
        await this.findMotor(this.customer.id_customer)
      }
    },
    async deleteHandler2 () {
      await this.deleteMotor(this.id_motorcycle)
      await this.findMotor(this.customer.id_customer)
      this.warning2=false
    },
    async searchcustomer()
    {
        await this.findCustomer(this.customer.id_customer);
        await this.findMotor(this.customer.id_customer);
    },
    cancelSubmit(){
      this.add=false
      this.hide=true
    },
    cancelSubmit2(){
      this.add2=false
      this.hide2=true
    },
    deleteWarning2(id){
        this.id_motorcycle=id
        this.warning2=true
    },
    async resetcustomer()
    {
        this.customer.id_customer=""
        this.customer.customer_name=""
        this.customer.customer_address=""
        this.customer.customer_phone_number=""
        await this.findMotor(0);
    },
    async submitService()
    {
        var i = 0
        this.err = false
        var object = this.service
        for(var data in this.transaction.service)
        {
            if(this.transaction.service[i].id_service==object.id_service && this.transaction.service[i].id_motorcycle==object.id_motorcycle )
            {
                this.err = true
            }
            i++;
        }
        await this.findService(this.service.id_service)
        object.service_name=this.serviceData.service_name
        object.detail_service_price=this.serviceData.price
        await this.fetchMotor(this.service.id_motorcycle)
        object.license_number=this.motorcycle.license_number
        await this.findEmployee(this.service.id_employee)
        object.mechanic_name=this.employee.first_name + ' ' + this.employee.last_name
        if(!this.err)
        {
            this.transaction.service.push(JSON.parse(JSON.stringify(object)))
        }
    },
    bindData(item){
        this.motorcycle.license_number=item.license_number
        this.motorcycle.id_motorcycle_brand=item.id_motorcycle_brand
        this.motorcycle.id_motorcycle_type=item.id_motorcycle_type
    },
    filterType(id){
      console.log(id)
      this.id_motorcycle_brand=id
    },
    addHandler(){
      this.add=true
      this.hide=false
    },
    addHandler2(){
      this.add2=true
      this.hide2=false
    },
    async submitMotor (value) {
      const payload = {
        license_number: value.license_number,
        id_motorcycle_type: value.id_motorcycle_type,
        id_customer: this.customer.id_customer
      }

      await this.storeMotor(payload)
    
      if (!this.motorError) {
        this.add=false
        this.hide=true
        await this.findMotor(this.customer.id_customer)
      }
    },
  },

  mounted () {
    this.fetchCustomer()
    this.getBrand()
    this.getType()
    this.getService()
    this.getEmployee()
  }
   
}
</script>

<style scoped>
.loading-section {
  text-align: center;
}
</style>


