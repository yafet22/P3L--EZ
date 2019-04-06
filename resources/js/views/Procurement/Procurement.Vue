<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
    <card>
      <v-container grid-list-md mb-0>
        <h1 class="text-md-center">DATA PENGADAAN SPAREPART</h1>
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
                Pesan Sparepart
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
      <ProcurementControl ref="procurementControl">
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
              <td v-html="props.item.id_procurement" />
              <td v-html="props.item.date" />
              <td v-html="props.item.procurement_status" />
              <td class="text-xs-center">
                <VBtn 
                  flat
                  color="info"
                 
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
                  @click="editHandler(props.item.id_procurement)"
                >
                  <v-icon>edit</v-icon>
                </VBtn>
                <VBtn 
                  flat
                  icon
                  color="error"
                  dark
                  @click="deleteWarning(props.item.id_procurement)"
                >
                  <v-icon>delete</v-icon>
                </VBtn>
              </td>
            </template>
          </VDataTable>
        </template>
      </ProcurementControl>
    
      <v-dialog v-model="warning" persistent max-width="500">
        <v-card>
            <v-card-title class="headline">Warning!</v-card-title>
            <VCardText
              v-if="procurementLoading || procurementError"
              class="text-xs-center"
            >
              <VAlert
                v-if="procurementError"
                :value="true"
                dismissible
                type="error"
              >
              {{ procurementError.message }}
              </VAlert>
              <VProgressCircular
                v-if="procurementLoading"
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
import ProcurementForm from '../../components/Form/ProcurementForm'
import ProcurementControl from '../../components/Renderless/ProcurementControl'
import procurementService from '../../service/Procurement'
import { mapActions,mapState } from 'vuex';

export default {
  components: {
    ProcurementControl,
    ProcurementForm
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
            text: 'Tanggal',
            value: 'date'
          },
          {
            text: 'Status',
            value: 'procurement_status'
          },
          {
            text: 'Verifikasi',
            value: null
          },
          {
            text: 'Cetak SP',
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
          text: 'Procurement',
          disabled: true,
        },
      ]
    }
  },

  computed: {
    ...mapState({
      procurementError: state => state.Procurement.error,
      procurementLoading: state => state.Procurement.loading
    })
  },


  methods: {
    ...mapActions({
      deleteProcurement: 'Procurement/delete',
      storeProcurement: 'Procurement/store',
      resetForm: 'Procurement/resetForm',
      updateProcurement: 'Procurement/update',
      fetchProcurement: 'Procurement/edit',
    }),

    fetch () {
      this.$refs.procurementControl.fetch()
    },

    async editHandler(id){
      console.log(id)
      this.id_procurement=id
      await this.fetchProcurement(id)
      this.dialog2=true
    },

    deleteWarning(id){
        this.id_procurement=id
        this.warning=true
    },

    async deleteHandler () {
      console.log(this.id_procurement);
      await this.deleteProcurement(this.id_procurement)
      this.fetch()
      this.warning=false
    },

    async submitHandler (value) {
      const payload = {
        date: value.date,
        procurement_status: value.procurement_status,
        id_sales: value.id_sales
      }

      await this.storeProcurement(payload)
    
      if (!this.procurementError) {
        this.dialog=false
        this.fetch()
      }
    },

    async submitHandler2 (value) {
      
      console.log(this.id_procurement);
      const payload = {
        id_procurement: this.id_procurement,
        date: value.date,
        procurement_status: value.procurement_status,
        id_sales: value.id_sales
      }

      await this.updateProcurement(payload)
    
      if (!this.procurementError) {
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


