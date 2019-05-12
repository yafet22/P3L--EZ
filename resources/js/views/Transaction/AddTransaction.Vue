<template>
 <PageWrapper :breadcrumbs="breadcrumbs">
    <card>
     <v-layout row wrap>
        <v-flex sm12>
         <v-card>
           <v-layout row wrap>
            <v-flex sm6>
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
                              :error-messages="customerNameErrors"
                              @input="$v.customer.customer_name.$touch()"
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
                              :error-messages="customerAddressErrors"
                              @input="$v.customer.customer_address.$touch()"
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
                              :error-messages="customerPhoneNumberErrors"
                              @input="$v.customer.customer_phone_number.$touch()"
                              required
                          />
                          </VFlex>
                      </VLayout>
                      <VLayout>
                          <VFlex sm12 class="text-xs-center">
                          <VBtn
                            v-if="switchnewcustomer"
                            depressed
                            color="success"
                            @click="submitCustomer"
                            :disabled="$v.customer.$invalid"
                          >
                            Tambah Pelanggan
                          </VBtn>
                          </VFlex>
                      </VLayout>
                  </v-form>
              </v-card-text>
            </v-flex>
            <v-flex sm6>
              <v-card-title primary-title class="justify-center">
                    <div class="headline">JENIS TRANSAKSI</div>
                </v-card-title>
                <v-card-text>
                    <VLayout>
                        <VFlex>
                         <v-radio-group v-model="transaction.transaction_type" @change="resetList(transaction.transaction_type)" class="justify-center" row>
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
                    <td v-html="props.item.service_name" v-if="editedService != props.item.id_service && editMotor != props.item.id_motorcycle"/>
                    <td v-else>
                      <v-select
                          label="Tipe Service"
                          class="pa-1"
                          v-model="service.id_service"
                          item-text="service_name"
                          item-value="id_service"
                          @change="calculatePrice(service.id_service)"
                          :items="services"
                          :return-object="false"
                          required
                      ></v-select>
                    </td>
                    <td v-html="props.item.license_number" v-if="editedService != props.item.id_service && editMotor != props.item.id_motorcycle" />
                    <td v-else>
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
                    </td>         
                    <td v-html="props.item.mechanic_name" v-if="editedService != props.item.id_service && editMotor != props.item.id_motorcycle" />   
                    <td v-else>
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
                    </td>                         
                    <td v-html="props.item.detail_service_price" v-if="editedService != props.item.id_service && editMotor != props.item.id_motorcycle"/>    
                    <td v-html="servicePrice" v-else/>     
                    <td class="text-xs-center" v-if="editedService != props.item.id_service && editMotor != props.item.id_motorcycle">
                      <VBtn 
                        flat
                        icon
                        color="indigo"
                        dark
                        @click="bindDataService(props.item)"
                      >
                        <v-icon>edit</v-icon>
                      </VBtn>
                      <VBtn 
                        flat
                        icon
                        color="error"
                        @click="deleteService(props.item.id_service,props.item.id_motorcycle)"
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
                        @click="editService(props.item.id_service,props.item.id_motorcycle)"
                      >
                        <v-icon>check_circle</v-icon>
                      </VBtn>
                      <VBtn
                        flat
                        icon
                        depressed
                        color="error"
                        @click="editedMotor='',editedService=''"
                      >
                        <v-icon>remove_circle</v-icon>
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
                                :error-messages="serviceNameErrors"
                                @input="$v.service.id_service.$touch()"
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
                                :error-messages="serviceMotorErrors"
                                @input="$v.service.id_motorcycle.$touch()"
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
                                :error-messages="serviceMechanicErrorsErrors"
                                @input="$v.service.id_employee.$touch()"
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
                                :disabled="$v.service.$invalid"
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
            <v-card-actions>
                <VSpacer />
                <VBtn
                  depressed
                  color="success"
                  @click="submitTransaksi"
                  :disabled="$v.customer.$invalid || transaction.service.length==0"
                >
                  Tambah Transaksi
                </VBtn>
                <VSpacer />
            </v-card-actions>
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
                <VAlert
                    v-if="err2"
                    :value="true"
                    dismissible
                    type="error"
                >
                Transaki yang sama telah dilakukan
                </VAlert>
                <VDataTable
                  :headers="headers3"
                  :items="transaction.sparepart"
                  :search="keyword"
                >
                  <template slot="items" slot-scope="props">
                    <td v-html="props.item.sparepart_type" v-if="editedSparepart != props.item.id_sparepart && editMotor != props.item.id_motorcycle"/>
                    <td v-else>
                      <v-select
                          label="Tipe Sparepart"
                          class="pa-1"
                          v-model="sparepart.id_sparepart_type"
                          item-text="sparepart_type_name"
                          item-value="id_sparepart_type"
                          :items="sparepartTypes"
                          :return-object="false"
                          required
                      ></v-select>
                    </td>
                    <td v-html="props.item.sparepart_name" v-if="editedSparepart != props.item.id_sparepart && editMotor != props.item.id_motorcycle"/>   
                    <td v-html="sparepartName" v-else/>       
                    <td v-html="props.item.merk" v-if="editedSparepart != props.item.id_sparepart && editMotor != props.item.id_motorcycle"/>  
                    <td v-else>
                      <v-select
                          label="Merk"
                          class="pa-1"
                          v-model="sparepart.id_sparepart"
                          item-text="merk"
                          item-value="id_sparepart"
                          @change="calculateSparepart(sparepart.id_sparepart)"
                          :items="filterSparepart"
                          :return-object="false"
                          required
                      ></v-select>
                    </td>
                    <td v-html="props.item.detail_sparepart_price" v-if="editedSparepart != props.item.id_sparepart && editMotor != props.item.id_motorcycle"/>
                    <td v-html="sparepartPrice" v-else/>                          
                    <td v-html="props.item.detail_sparepart_amount" v-if="editedSparepart != props.item.id_sparepart && editMotor != props.item.id_motorcycle"/>
                    <td v-else>
                      <v-text-field
                        v-model="sparepart.detail_sparepart_amount"
                        class="pa-1"
                        label="Jumlah"
                        required
                        @change="calculateSparepartPrice(sparepart.detail_sparepart_amount)"
                      ></v-text-field>
                    </td>  
                    <td v-html="props.item.license_number" v-if="editedSparepart != props.item.id_sparepart && editMotor != props.item.id_motorcycle"/> 
                    <td v-else>
                      <v-select
                          label="Motor Pelanggan"
                          class="pa-1"
                          v-model="sparepart.id_motorcycle"
                          item-text="license_number"
                          item-value="id_motorcycle"
                          :items="motorcycles"
                          :return-object="false"
                          required
                      ></v-select>
                    </td>  
                    <td v-html="props.item.mechanic_name" v-if="editedSparepart != props.item.id_sparepart && editMotor != props.item.id_motorcycle"/>
                    <td v-else>
                      <v-select
                          label="Montir"
                          class="pa-1"
                          v-model="sparepart.id_employee"
                          item-text="name"
                          item-value="id_employee"
                          :items="mechanic"
                          :return-object="false"
                          required
                      ></v-select>
                    </td>   
                    <td v-html="props.item.detail_sparepart_subtotal" v-if="editedSparepart != props.item.id_sparepart && editMotor != props.item.id_motorcycle"/>
                    <td v-html="sparepartSubTotal" v-else/>     
                    <td class="text-xs-center" v-if="editedSparepart != props.item.id_sparepart && editMotor != props.item.id_motorcycle">
                      <VBtn 
                        flat
                        icon
                        color="indigo"
                        dark
                        @click="bindDataSparepart(props.item)"
                      >
                        <v-icon>edit</v-icon>
                      </VBtn>
                      <VBtn 
                        flat
                        icon
                        color="error"
                        @click="deleteSparepart(props.item.id_sparepart,props.item.id_motorcycle)"
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
                        @click="editSparepart(props.item.id_sparepart,props.item.id_motorcycle)"
                      >
                        <v-icon>check_circle</v-icon>
                      </VBtn>
                      <VBtn
                        flat
                        icon
                        depressed
                        color="error"
                        @click="editedMotor='',editedSparepart=''"
                      >
                        <v-icon>remove_circle</v-icon>
                      </VBtn>
                    </td>
                  </template>
                  <template v-slot:footer>
                    <td :colspan="headers3.length" v-if="add3">
                      <v-form class="mt-2">
                        <VLayout>
                            <VFlex sm3>
                            <v-select
                                label="Tipe Sparepart"
                                class="pa-1"
                                v-model="sparepart.id_sparepart_type"
                                item-text="sparepart_type_name"
                                item-value="id_sparepart_type"
                                :items="sparepartTypes"
                                :return-object="false"
                                :error-messages="sparepartTypeErrors"
                                @input="$v.sparepart.id_sparepart_type.$touch()"
                                required
                            ></v-select>
                            </VFlex>
                            <VFlex sm2>
                            <v-select
                                label="Merk"
                                class="pa-1"
                                v-model="sparepart.id_sparepart"
                                item-text="merk"
                                item-value="id_sparepart"
                                :items="filterSparepart"
                                :return-object="false"
                                :error-messages="sparepartMerkErrors"
                                @input="$v.sparepart.id_sparepart.$touch()"
                                required
                            ></v-select>
                            </VFlex>
                            <VFlex sm1>
                              <v-text-field
                                v-model="sparepart.detail_sparepart_amount"
                                class="pa-1"
                                label="Jumlah"
                                :error-messages="sparepartAmountErrors"
                                @input="$v.sparepart.detail_sparepart_amount.$touch()"
                                required
                              ></v-text-field>
                            </VFlex>
                            <VFlex sm2>
                            <v-select
                                label="Motor Pelanggan"
                                class="pa-1"
                                v-model="sparepart.id_motorcycle"
                                item-text="license_number"
                                item-value="id_motorcycle"
                                :items="motorcycles"
                                :return-object="false"
                                required
                            ></v-select>
                            </VFlex>
                            <VFlex sm2>
                            <v-select
                                label="Montir"
                                class="pa-1"
                                v-model="sparepart.id_employee"
                                item-text="name"
                                item-value="id_employee"
                                :items="mechanic"
                                :return-object="false"
                                required
                            ></v-select>
                            </VFlex>
                            <VFlex sm2
                            class="text-xs-center"
                            >
                            <VBtn
                                flat
                                icon
                                depressed
                                color="success"
                                @click="submitSparepart"
                                :disabled="$v.sparepart.$invalid"
                            >
                                <v-icon>check_box</v-icon>
                            </VBtn>
                            <VBtn
                                flat
                                icon
                                depressed
                                @click="cancelSubmit3"
                                color="error"
                            >
                                <v-icon>remove_circle</v-icon>
                            </VBtn>
                            </VFlex>
                        </VLayout>
                    </v-form>
                    </td>
                    <td style="text-align:right;" :colspan="headers3.length" v-if="hide3" >
                      <VBtn
                        flat
                        icon
                        depressed
                        color="success"
                        @click="addHandler3()"
                      >
                        <v-icon>add_circle</v-icon>
                      </VBtn>
                    </td>
                  </template>
                </VDataTable>
            </v-card-text>
            <v-card-actions>
                <VSpacer />
                <VBtn
                  depressed
                  color="success"
                  @click="submitTransaksi"
                  :disabled="$v.customer.$invalid || transaction.sparepart.length==0"
                >
                  Tambah Transaksi
                </VBtn>
                <VSpacer />
            </v-card-actions>
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
                    <td v-html="props.item.service_name" v-if="editedService != props.item.id_service && editMotor != props.item.id_motorcycle"/>
                    <td v-else>
                      <v-select
                          label="Tipe Service"
                          class="pa-1"
                          v-model="service.id_service"
                          item-text="service_name"
                          item-value="id_service"
                          @change="calculatePrice(service.id_service)"
                          :items="services"
                          :return-object="false"
                          required
                      ></v-select>
                    </td>
                    <td v-html="props.item.license_number" v-if="editedService != props.item.id_service && editMotor != props.item.id_motorcycle" />
                    <td v-else>
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
                    </td>         
                    <td v-html="props.item.mechanic_name" v-if="editedService != props.item.id_service && editMotor != props.item.id_motorcycle" />   
                    <td v-else>
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
                    </td>                         
                    <td v-html="props.item.detail_service_price" v-if="editedService != props.item.id_service && editMotor != props.item.id_motorcycle"/>    
                    <td v-html="servicePrice" v-else/>     
                    <td class="text-xs-center" v-if="editedService != props.item.id_service && editMotor != props.item.id_motorcycle">
                      <VBtn 
                        flat
                        icon
                        color="indigo"
                        dark
                        @click="bindDataService(props.item)"
                      >
                        <v-icon>edit</v-icon>
                      </VBtn>
                      <VBtn 
                        flat
                        icon
                        color="error"
                        @click="deleteService(props.item.id_service,props.item.id_motorcycle)"
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
                        @click="editService(props.item.id_service,props.item.id_motorcycle)"
                      >
                        <v-icon>check_circle</v-icon>
                      </VBtn>
                      <VBtn
                        flat
                        icon
                        depressed
                        color="error"
                        @click="editedMotor='',editedService=''"
                      >
                        <v-icon>remove_circle</v-icon>
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
                                :error-messages="serviceNameErrors"
                                @input="$v.service.id_service.$touch()"
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
                                :error-messages="serviceMotorErrors"
                                @input="$v.service.id_motorcycle.$touch()"
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
                                :error-messages="serviceMechanicErrorsErrors"
                                @input="$v.service.id_employee.$touch()"
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
                                :disabled="$v.service.$invalid"
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
     <v-layout row wrap mt-1 v-if="transaction.transaction_type=='Service And Sparepart'">
         <v-flex sm12 >
           <v-card>
            <v-card-title primary-title class="justify-center">
                <div class="headline">DAFTAR SPAREPART</div>
            </v-card-title>
            <v-card-text>
                <VAlert
                    v-if="err2"
                    :value="true"
                    dismissible
                    type="error"
                >
                Transaki yang sama telah dilakukan
                </VAlert>
                <VDataTable
                  :headers="headers3"
                  :items="transaction.sparepart"
                  :search="keyword"
                >
                  <template slot="items" slot-scope="props">
                    <td v-html="props.item.sparepart_type" v-if="editedSparepart != props.item.id_sparepart && editMotor != props.item.id_motorcycle"/>
                    <td v-else>
                      <v-select
                          label="Tipe Sparepart"
                          class="pa-1"
                          v-model="sparepart.id_sparepart_type"
                          item-text="sparepart_type_name"
                          item-value="id_sparepart_type"
                          :items="sparepartTypes"
                          :return-object="false"
                          required
                      ></v-select>
                    </td>
                    <td v-html="props.item.sparepart_name" v-if="editedSparepart != props.item.id_sparepart && editMotor != props.item.id_motorcycle"/>   
                    <td v-html="sparepartName" v-else/>       
                    <td v-html="props.item.merk" v-if="editedSparepart != props.item.id_sparepart && editMotor != props.item.id_motorcycle"/>  
                    <td v-else>
                      <v-select
                          label="Merk"
                          class="pa-1"
                          v-model="sparepart.id_sparepart"
                          item-text="merk"
                          item-value="id_sparepart"
                          @change="calculateSparepart(sparepart.id_sparepart)"
                          :items="filterSparepart"
                          :return-object="false"
                          required
                      ></v-select>
                    </td>
                    <td v-html="props.item.detail_sparepart_price" v-if="editedSparepart != props.item.id_sparepart && editMotor != props.item.id_motorcycle"/>
                    <td v-html="sparepartPrice" v-else/>                          
                    <td v-html="props.item.detail_sparepart_amount" v-if="editedSparepart != props.item.id_sparepart && editMotor != props.item.id_motorcycle"/>
                    <td v-else>
                      <v-text-field
                        v-model="sparepart.detail_sparepart_amount"
                        class="pa-1"
                        label="Jumlah"
                        required
                        @change="calculateSparepartPrice(sparepart.detail_sparepart_amount)"
                      ></v-text-field>
                    </td>  
                    <td v-html="props.item.license_number" v-if="editedSparepart != props.item.id_sparepart && editMotor != props.item.id_motorcycle"/> 
                    <td v-else>
                      <v-select
                          label="Motor Pelanggan"
                          class="pa-1"
                          v-model="sparepart.id_motorcycle"
                          item-text="license_number"
                          item-value="id_motorcycle"
                          :items="motorcycles"
                          :return-object="false"
                          required
                      ></v-select>
                    </td>  
                    <td v-html="props.item.mechanic_name" v-if="editedSparepart != props.item.id_sparepart && editMotor != props.item.id_motorcycle"/>
                    <td v-else>
                      <v-select
                          label="Montir"
                          class="pa-1"
                          v-model="sparepart.id_employee"
                          item-text="name"
                          item-value="id_employee"
                          :items="mechanic"
                          :return-object="false"
                          required
                      ></v-select>
                    </td>   
                    <td v-html="props.item.detail_sparepart_subtotal" v-if="editedSparepart != props.item.id_sparepart && editMotor != props.item.id_motorcycle"/>
                    <td v-html="sparepartSubTotal" v-else/>     
                    <td class="text-xs-center" v-if="editedSparepart != props.item.id_sparepart && editMotor != props.item.id_motorcycle">
                      <VBtn 
                        flat
                        icon
                        color="indigo"
                        dark
                        @click="bindDataSparepart(props.item)"
                      >
                        <v-icon>edit</v-icon>
                      </VBtn>
                      <VBtn 
                        flat
                        icon
                        color="error"
                        @click="deleteSparepart(props.item.id_sparepart,props.item.id_motorcycle)"
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
                        @click="editSparepart(props.item.id_sparepart,props.item.id_motorcycle)"
                      >
                        <v-icon>check_circle</v-icon>
                      </VBtn>
                      <VBtn
                        flat
                        icon
                        depressed
                        color="error"
                        @click="editedMotor='',editedSparepart=''"
                      >
                        <v-icon>remove_circle</v-icon>
                      </VBtn>
                    </td>
                  </template>
                  <template v-slot:footer>
                    <td :colspan="headers3.length" v-if="add3">
                      <v-form class="mt-2">
                        <VLayout>
                            <VFlex sm3>
                            <v-select
                                label="Tipe Sparepart"
                                class="pa-1"
                                v-model="sparepart.id_sparepart_type"
                                item-text="sparepart_type_name"
                                item-value="id_sparepart_type"
                                :items="sparepartTypes"
                                :return-object="false"
                                :error-messages="sparepartTypeErrors"
                                @input="$v.sparepart.id_sparepart_type.$touch()"
                                required
                            ></v-select>
                            </VFlex>
                            <VFlex sm2>
                            <v-select
                                label="Merk"
                                class="pa-1"
                                v-model="sparepart.id_sparepart"
                                item-text="merk"
                                item-value="id_sparepart"
                                :items="filterSparepart"
                                :return-object="false"
                                :error-messages="sparepartMerkErrors"
                                @input="$v.sparepart.id_sparepart.$touch()"
                                required
                            ></v-select>
                            </VFlex>
                            <VFlex sm1>
                              <v-text-field
                                v-model="sparepart.detail_sparepart_amount"
                                class="pa-1"
                                label="Jumlah"
                                :error-messages="sparepartAmountErrors"
                                @input="$v.sparepart.detail_sparepart_amount.$touch()"
                                required
                              ></v-text-field>
                            </VFlex>
                            <VFlex sm2>
                            <v-select
                                label="Motor Pelanggan"
                                class="pa-1"
                                v-model="sparepart.id_motorcycle"
                                item-text="license_number"
                                item-value="id_motorcycle"
                                :items="motorcycles"
                                :return-object="false"
                                required
                            ></v-select>
                            </VFlex>
                            <VFlex sm2>
                            <v-select
                                label="Montir"
                                class="pa-1"
                                v-model="sparepart.id_employee"
                                item-text="name"
                                item-value="id_employee"
                                :items="mechanic"
                                :return-object="false"
                                required
                            ></v-select>
                            </VFlex>
                            <VFlex sm2
                            class="text-xs-center"
                            >
                            <VBtn
                                flat
                                icon
                                depressed
                                color="success"
                                @click="submitSparepart"
                                :disabled="$v.sparepart.$invalid"
                            >
                                <v-icon>check_box</v-icon>
                            </VBtn>
                            <VBtn
                                flat
                                icon
                                depressed
                                @click="cancelSubmit3"
                                color="error"
                            >
                                <v-icon>remove_circle</v-icon>
                            </VBtn>
                            </VFlex>
                        </VLayout>
                    </v-form>
                    </td>
                    <td style="text-align:right;" :colspan="headers3.length" v-if="hide3" >
                      <VBtn
                        flat
                        icon
                        depressed
                        color="success"
                        @click="addHandler3()"
                      >
                        <v-icon>add_circle</v-icon>
                      </VBtn>
                    </td>
                  </template>
                </VDataTable>
            </v-card-text>
            <v-card-actions>
                <VSpacer />
                <VBtn
                  depressed
                  color="success"
                  @click="submitTransaksi"
                  :disabled="$v.customer.$invalid || transaction.service.length==0 || transaction.sparepart.length==0"
                >
                  Tambah Transaksi
                </VBtn>
                <VSpacer />
            </v-card-actions>
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
      <v-dialog v-model="success" persistent max-width="500">
        <v-card>
            <v-card-title class="headline">Transaksi Berhasil!</v-card-title>
            <VCardText
              class="text-xs-center"
            >
              <VAlert
                v-if="transactionerror"
                :value="true"
                dismissible
                type="transactionerror"
              >
              {{ sparepartError.message }}
              </VAlert>
              <VProgressLinear 
                  v-if="transactionloading"
                  indeterminate
              />
            </VCardText>
            <v-card-text class="text-md-center" style="font-size:15px">Kembali Ke halaman transaksi</v-card-text>
            <v-card-actions>
            <v-spacer/>
            <VBtn class="mb-4" depressed dark color="green accent-3"  :to="{ name: 'transactions' }">Ok</VBtn>
            <v-spacer/>
            </v-card-actions>
        </v-card>
      </v-dialog>
    </card>
 </PageWrapper>
</template>

<script>
import MotorcycleForm from '../../components/Form/MotorcycleForm'
import { required,maxLength,numeric} from 'vuelidate/lib/validators'
import { mapGetters,mapState, mapActions } from 'vuex';

export default {
  components: {
      MotorcycleForm
  },
  validations: {
    customer : {
      customer_name: { required },
      customer_address : { required },
      customer_phone_number : {required }
    },
    sparepart: {
        id_sparepart_type: { required },
        id_sparepart: { required },
        detail_sparepart_amount: { required,numeric }
    },
    service: {
        id_service: { required },
        id_employee: { required },
        id_motorcycle: { required },
    },
  },
  data () {
    return {
      isFormValid2: "",
      add: false,
      hide: true,
      add2: false,
      hide2: true,
      add3: false,
      hide3: true,
      value2: false,
      value: false,
      edit: false,
      switchnewcustomer: false,
      row: null,
      err: false,
      err2: false,
      success: false,
      keyword: "",
      id_motorcycle: "",
      warning2: "",
      editedService: "",
      editedSparepart: "",
      editedMotor: "",
      servicePrice:0,
      sparepartPrice:0,
      sparepartName:"",
      sparepartSubTotal:0,
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
          detail_service_price: 0
      },
      sparepart: {
          id_sparepart_type: "",
          id_sparepart: "",
          sparepart_name: "",
          merk: "",
          id_employee: "",
          mechanic_name: "",
          id_motorcycle: "",
          license_number: "",
          detail_sparepart_price: 0,
          detail_sparepart_amount: 0,
          detail_sparepart_subtotal: 0
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
      headers3: [
          {
            text: 'Type',
            value: 'sparepart_type'
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
            text: 'Satuan',
            value: 'detail_sparepart_price'
          },
          {
            text: 'Jumlah',
            value: 'detail_sparepart_amount'
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
            text: 'Subtotal',
            value: 'detail_sparepart_subtotal'
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
        sparepartData: 'Sparepart/sparepart',
        sparepartTypeData: 'SparepartType/sparepartType',
        employee: 'Employee/employee',
        id_employee: 'LoggedUser/id',
    }),

    ...mapState({
        customers: state => state.Customer.customers,
        customerloading: state => state.Customer.loading,
        customererror: state => state.Customer.error,
        transactionloading: state => state.Transaction.loading,
        transactionerror: state => state.Transaction.error,
        motorcycles: state => state.Motorcycle.motorcycles, 
        motorError: state => state.Motorcycle.error,       
        brand: state => state.MotorcycleBrand.motorcycleBrands,
        type: state => state.MotorcycleType.motorcycleTypes,
        services: state => state.Service.services,
        spareparts: state => state.Sparepart.spareparts,
        sparepartTypes: state => state.SparepartType.sparepartTypes,
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

    filterSparepart(){
        let filter = this.spareparts.filter( b => b.id_sparepart_type === this.sparepart.id_sparepart_type)
        return filter
    },

    customerNameErrors () {
      const errors = []

      if (!this.$v.customer.customer_name.$dirty) return errors 
     
      !this.$v.customer.customer_name.required && errors.push('Nama Customer tidak boleh kosong')

      return errors
    },

    customerAddressErrors () {
      const errors = []

      if (!this.$v.customer.customer_address.$dirty) return errors 
     
      !this.$v.customer.customer_address.required && errors.push('Alamat Customer tidak boleh kosong')

      return errors
    },

    customerPhoneNumberErrors () {
      const errors = []

      if (!this.$v.customer.customer_phone_number.$dirty) return errors 
     
      !this.$v.customer.customer_phone_number.required && errors.push('Nomor HP Customer tidak boleh kosong')

      return errors
    },

    sparepartTypeErrors () {
      const errors = []

      if (!this.$v.sparepart.id_sparepart_type.$dirty) return errors 
     
      !this.$v.sparepart.id_sparepart_type.required && errors.push('Sparepart type tidak boleh kosong')

      return errors
    },

    sparepartMerkErrors () {
      const errors = []

      if (!this.$v.sparepart.id_sparepart.$dirty) return errors 
     
      !this.$v.sparepart.id_sparepart.required && errors.push('Merk sparepart tidak boleh kosong')

      return errors
    },

    sparepartAmountErrors () {
      const errors = []

      if (!this.$v.sparepart.detail_sparepart_amount.$dirty) return errors 

      !this.$v.sparepart.detail_sparepart_amount.numeric && errors.push('Input jumlah tidak valid')

      !this.$v.sparepart.detail_sparepart_amount.required && errors.push('Merk sparepart tidak boleh kosong')

      return errors
    },

    serviceNameErrors () {
      const errors = []

      if (!this.$v.service.id_service.$dirty) return errors 
     
      !this.$v.service.id_service.required && errors.push('jasa service tidak boleh kosong')

      return errors
    },

    serviceMotorErrors () {
      const errors = []

      if (!this.$v.service.id_motorcycle.$dirty) return errors 
     
      !this.$v.service.id_motorcycle.required && errors.push('Motor tidak boleh kosong')

      return errors
    },

    serviceMechanicErrors () {
      const errors = []

      if (!this.$v.service.id_employee.$dirty) return errors 
     
      !this.$v.service.id_employee.required && errors.push('Mechanic tidak boleh kosong')

      return errors
    },
  },  

  methods: {
    ...mapActions({
      fetchCustomer: 'Customer/get',
      findCustomer: 'Customer/edit',
      storeCustomer: 'Customer/store',
      findMotor: 'Motorcycle/findByUser',
      storeMotor: 'Motorcycle/store',
      deleteMotor: 'Motorcycle/delete',
      fetchMotor: 'Motorcycle/edit',
      updateMotor: 'Motorcycle/update',
      getBrand: 'MotorcycleBrand/get',
      getType: 'MotorcycleType/get',
      resetMotor: 'Motorcycle/resetForm',
      getSparepart: 'Sparepart/get',
      getService: 'Service/get',
      getEmployee: 'Employee/get',
      findService: 'Service/edit',
      findSparepart: 'Sparepart/edit',
      findSparepartType: 'SparepartType/edit',
      findEmployee: 'Employee/edit',
      storeTransaction: 'Transaction/store',
      getSparepartType: 'SparepartType/get'
    }),

    resetList(id){
        if(id=='Service')
        {
            console.log("hehe")
            this.transaction.sparepart=[]
        }
        else if(id=='Sparepart')
        {
            this.transaction.service=[]
        }
    },

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
    cancelSubmit3(){
      this.add3=false
      this.hide3=true
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
        object.detail_service_amount=1
        object.detail_service_subtotal=object.detail_service_amount=1*object.detail_service_price

        if(!this.err)
        {
            this.transaction.service.push(JSON.parse(JSON.stringify(object)))
            this.transaction.transaction_total=this.transaction.transaction_total+object.detail_service_price
            this.add2=false
            this.hide2=true
        }
    },
    async submitSparepart()
    {
        var i = 0
        this.err2 = false
        var object = this.sparepart
        for(var data in this.transaction.sparepart)
        {
            if(this.transaction.sparepart[i].id_sparepart==object.id_sparepart && this.transaction.sparepart[i].id_motorcycle==object.id_motorcycle )
            {
                this.err2 = true
            }
            i++;
        }
        await this.findSparepartType(this.sparepart.id_sparepart_type)
        object.sparepart_type=this.sparepartTypeData.sparepart_type_name
        await this.findSparepart(this.sparepart.id_sparepart)
        object.sparepart_name=this.sparepartData.sparepart_name
        object.merk=this.sparepartData.merk
        object.detail_sparepart_price=this.sparepartData.sell_price
        object.detail_sparepart_subtotal=this.sparepartData.sell_price*(Number(this.sparepart.detail_sparepart_amount))
        await this.fetchMotor(this.sparepart.id_motorcycle)
        object.license_number=this.motorcycle.license_number
        await this.findEmployee(this.sparepart.id_employee)
        object.mechanic_name=this.employee.first_name + ' ' + this.employee.last_name
        if(!this.err2)
        {
            this.transaction.sparepart.push(JSON.parse(JSON.stringify(object)))
            this.transaction.transaction_total=this.transaction.transaction_total+object.detail_sparepart_subtotal
            this.add3=false
            this.hide3=true
        }
    },
    deleteService(id_service,id_motorcycle)
    {
      var i = 0
      for(var data in this.transaction.service)
      {
          if(this.transaction.service[i].id_service==id_service && this.transaction.service[i].id_motorcycle==id_motorcycle )
          {
              this.transaction.transaction_total=this.transaction.transaction_total-this.transaction.service[i].detail_service_price
          }
          i++;
      }
      let filter = this.transaction.service.filter(function( obj ) {
        return obj.id_service != id_service && obj.id_motorcycle !=id_motorcycle;
      });
      this.transaction.service=filter
    },
    deleteSparepart(id_sparepart,id_motorcycle)
    {
      var i = 0
      for(var data in this.transaction.sparepart)
      {
          if(this.transaction.sparepart[i].id_sparepart==id_sparepart && this.transaction.sparepart[i].id_motorcycle==id_motorcycle )
          {
              this.transaction.transaction_total=this.transaction.transaction_total-this.transaction.sparepart[i].detail_sparepart_price
          }
          i++;
      }
      let filter = this.transaction.sparepart.filter(function( obj ) {
        return obj.id_sparepart != id_sparepart && obj.id_motorcycle !=id_motorcycle;
      });
      this.transaction.sparepart=filter
    },
    async editService(id_service,id_motorcycle)
    {
        var i = 0
        for(var data in this.transaction.service)
        {
            if(this.transaction.service[i].id_service==id_service && this.transaction.service[i].id_motorcycle==id_motorcycle )
            {
                this.transaction.transaction_total=this.transaction.transaction_total-this.transaction.service[i].detail_service_price
                this.transaction.service[i].id_service=this.service.id_service
                await this.findService(this.service.id_service)
                this.transaction.service[i].service_name=this.serviceData.service_name
                this.transaction.service[i].detail_service_price=this.serviceData.price
                this.transaction.service[i].id_motorcycle=this.service.id_motorcycle
                await this.fetchMotor(this.service.id_motorcycle)
                this.transaction.service[i].license_number=this.motorcycle.license_number
                this.transaction.service[i].id_employee=this.service.id_employee
                await this.findEmployee(this.service.id_employee)
                this.transaction.service[i].mechanic_name=this.employee.first_name + ' ' + this.employee.last_name
                this.transaction.transaction_total=this.transaction.transaction_total+this.transaction.service[i].detail_service_price
            }
            i++;
        }
        this.editedMotor=""
        this.editedService=""
    },
    async editSparepart(id_sparepart,id_motorcycle)
    {
        var i = 0
        for(var data in this.transaction.sparepart)
        {
            if(this.transaction.sparepart[i].id_sparepart==id_sparepart && this.transaction.sparepart[i].id_motorcycle==id_motorcycle )
            {
                this.transaction.transaction_total=this.transaction.transaction_total-this.transaction.sparepart[i].detail_sparepart_subtotal
                this.transaction.sparepart[i].id_sparepart=this.sparepart.id_sparepart
                this.transaction.sparepart[i].sparepart_name=this.sparepartName
                this.transaction.sparepart[i].detail_sparepart_amount=this.sparepart.detail_sparepart_amount
                this.transaction.sparepart[i].detail_sparepart_price=this.sparepartPrice
                this.transaction.sparepart[i].detail_sparepart_subtotal=this.sparepartSubTotal
                this.transaction.sparepart[i].id_motorcycle=this.sparepart.id_motorcycle
                await this.fetchMotor(this.sparepart.id_motorcycle)
                this.transaction.sparepart[i].license_number=this.motorcycle.license_number
                this.transaction.sparepart[i].id_employee=this.sparepart.id_employee
                await this.findEmployee(this.sparepart.id_employee)
                this.transaction.sparepart[i].mechanic_name=this.employee.first_name + ' ' + this.employee.last_name
                this.transaction.transaction_total=this.transaction.transaction_total+this.transaction.sparepart[i].detail_sparepart_subtotal
            }
            i++;
        }
        this.editedMotor=""
        this.editedSparepart=""
    },
    async calculatePrice(id_service)
    {
        await this.findService(id_service)
        this.servicePrice = this.serviceData.price
    },
    async calculateSparepart(id_sparepart)
    {
        await this.findSparepart(id_sparepart)
        this.sparepartPrice = this.sparepartData.sell_price
        this.sparepartName = this.sparepartData.sparepart_name
        this.sparepartSubTotal = this.sparepart.detail_sparepart_amount * this.sparepartPrice
    },
    async calculateSparepartPrice(amount)
    {
        this.sparepartSubTotal = amount * this.sparepartPrice
    },
    async submitTransaksi()
    {
        const payload = {
          id_customer: this.customer.id_customer,
          transaction_status: this.transaction.transaction_status,
          transaction_type: this.transaction.transaction_type,
          transaction_total: this.transaction.transaction_total,
          service: this.transaction.service,
          sparepart: this.transaction.sparepart,
          employee: this.id_employee
        }

        await this.storeTransaction(payload)

        if (!this.transactionerror) {
          this.success=true
      }
    },
    async submitCustomer()
    {
        // const payload = {
        //   id_customer: this.customer.id_customer,
        //   transaction_status: this.transaction.transaction_status,
        //   transaction_type: this.transaction.transaction_type,
        //   transaction_total: this.transaction.transaction_total,
        //   service: this.transaction.service,
        //   sparepart: this.transaction.sparepart,
        //   employee: this.id_employee
        // }

        await this.storeCustomer(this.customer)
        if (!this.customererror) {
          await this.fetchCustomer()
          await this.findCustomer(this.customer.id_customer);
          this.switchnewcustomer=false
          // this.success=true
      }
    },
    bindData(item){
        this.motorcycle.license_number=item.license_number
        this.motorcycle.id_motorcycle_brand=item.id_motorcycle_brand
        this.motorcycle.id_motorcycle_type=item.id_motorcycle_type
    },
    bindDataService(item)
    {
        this.editedService = item.id_service
        this.editedMotor = item.id_motorcycle
        this.service.id_service=item.id_service
        this.service.id_motorcycle=item.id_motorcycle
        this.service.id_employee=item.id_employee
        this.servicePrice = item.detail_service_price
    },
    bindDataSparepart(item)
    {
        this.editedSparepart = item.id_sparepart
        this.editedMotor = item.id_motorcycle
        this.sparepart.id_sparepart_type=item.id_sparepart_type
        this.sparepart.id_sparepart=item.id_sparepart
        this.sparepart.id_motorcycle=item.id_motorcycle
        this.sparepart.detail_sparepart_amount=item.detail_sparepart_amount
        this.sparepart.id_employee=item.id_employee
        this.sparepartPrice = item.detail_sparepart_price
        this.sparepartName = item.sparepart_name
        this.sparepartSubTotal = item.detail_sparepart_subtotal
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
    addHandler3(){
      this.add3=true
      this.hide3=false
    },
    async submitMotor (value) {
      const payload = {
        license_number: value.license_number,
        id_motorcycle_type: value.id_motorcycle_type,
        id_customer: this.customer.id_customer,
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
    this.getSparepart()
    this.getEmployee()
    this.getSparepartType()
  }
   
}
</script>

<style scoped>
.loading-section {
  text-align: center;
}
</style>


