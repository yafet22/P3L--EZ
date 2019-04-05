<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
    <card>
      <v-container grid-list-md mb-0>
        <h1 class="text-md-center">DATA JASA SERVICE</h1>
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
                Tambah Service
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
      <ServiceControl ref="serviceControl">
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
              <td v-html="props.item.id_service" />
              <td v-html="props.item.service_name" />
              <td v-html="props.item.price"/>
              <td class="text-xs-center">
                <VBtn 
                  flat
                  icon
                  color="indigo"
                  dark
                  @click="editHandler(props.item.id_service)"
                >
                  <v-icon>edit</v-icon>
                </VBtn>
                <VBtn 
                  flat
                  icon
                  color="error"
                  dark
                  @click="deleteWarning(props.item.id_service)"
                >
                  <v-icon>delete</v-icon>
                </VBtn>
              </td>
            </template>
          </VDataTable>
        </template>
      </ServiceControl>
      <v-dialog v-model="dialog" max-width="600px">
        <UtilityCard title="Tambah Service">
            <VCardText>
                <VAlert
                v-if="serviceError"
                v-html="serviceError.message"
                :value="true"
                dismissible
                type="error"
                />
                <ServiceForm 
                v-model="isFormValid"
                @submitted="submitHandler"
                />
            </VCardText>
        </UtilityCard>
      </v-dialog>
      <v-dialog v-model="dialog2" max-width="600px">
        <UtilityCard title="Ubah Data Servicer">
            <VCardText>
                <VAlert
                v-if="serviceError"
                v-html="serviceError.message"
                :value="true"
                dismissible
                type="error"
                />
                <ServiceForm 
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
              v-if="serviceLoading || serviceError"
              class="text-xs-center"
            >
              <VAlert
                v-if="error"
                :value="true"
                dismissible
                type="serviceError"
              >
              {{ serviceError.message }}
              </VAlert>
              <VProgressCircular
                v-if="serviceLoading"
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
import ServiceForm from '../../components/Form/ServiceForm'
import ServiceControl from '../../components/Renderless/ServiceControl'
import serviceService from '../../service/Service'
import { mapActions,mapState } from 'vuex';

export default {
  components: {
    ServiceControl,
    ServiceForm
  },
  data () {
    return {
      name: '',
      isFormValid: false,
      dialog: false,
      dialog2: false,
      warning: false,
      keyword: '',
      id_service: '',
      headers: [
          {
            text: 'ID',
            value: 'id_service',
          },
          {
            text: 'Nama',
            value: 'service_name'
          },
          {
            text: 'Harga',
            value: 'price'
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
          text: 'Service',
          disabled: true,
        },
      ]
    }
  },

  computed: {
    ...mapState({
      serviceError: state => state.Service.error,
      serviceLoading: state => state.Service.loading
    })
  },


  methods: {
    ...mapActions({
      deleteService: 'Service/delete',
      storeService: 'Service/store',
      resetForm: 'Service/resetForm',
      updateService: 'Service/update',
      fetchService: 'Service/edit',
    }),

    fetch () {
      this.$refs.serviceControl.fetch()
    },

    async editHandler(id){
      console.log(id)
      this.id_service=id
      await this.fetchService(id)
      this.dialog2=true
    },

    deleteWarning(id){
        this.id_service=id
        this.warning=true
    },

    async deleteHandler () {
      console.log(this.id_service);
      await this.deleteService(this.id_service)
      this.fetch()
      this.warning=false
    },

    async submitHandler (value) {
      const payload = {
        service_name: value.service_name,
        price: value.price,
      }

      await this.storeService(payload)
    
      if (!this.serviceError) {
        this.dialog=false
        this.fetch()
      }
    },

    async submitHandler2 (value) {
      
      console.log(this.id_service);
      const payload = {
        id_service: this.id_service,
        service_name: value.service_name,
        price: value.price,
      }

      await this.updateService(payload)
    
      if (!this.serviceError) {
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


