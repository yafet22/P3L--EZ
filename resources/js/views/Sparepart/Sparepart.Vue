<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
    <card>
      <v-container grid-list-md mb-0>
        <h1 class="text-md-center">DATA SPAREPART</h1>
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
                Tambah Sparepart
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
      <SparepartControl ref="sparepartControl">
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
              <td v-html="props.item.id_sparepart" />
              <td v-html="props.item.sparepart_name" />
              <td v-html="props.item.merk" />
              <td v-html="props.item.sparepart_type_name" />
              <td v-html="props.item.stock" />
              <td v-html="props.item.min_stock" />
              <td v-html="props.item.purchase_price" />
              <td v-html="props.item.sell_price" />
              <td v-html="props.item.placement" />
              <td class="text-xs-center" width="200px">
                <VBtn 
                  flat
                  icon
                  color="indigo"
                  dark
                  @click="editHandler(props.item.id_sparepart)"
                >
                  <v-icon>edit</v-icon>
                </VBtn>
                <VBtn 
                  flat
                  icon
                  color="error"
                  dark
                  @click="deleteWarning(props.item.id_sparepart)"
                >
                  <v-icon>delete</v-icon>
                </VBtn>
              </td>
            </template>
          </VDataTable>
        </template>
      </SparepartControl>
      <v-dialog v-model="dialog" max-width="600px">
        <UtilityCard title="Tambah Sparepart">
            <VCardText>
                <VAlert
                v-if="sparepartError"
                v-html="sparepartError.message"
                :value="true"
                dismissible
                type="error"
                />
                <SparepartForm 
                v-model="isFormValid"
                @submitted="submitHandler"
                />
            </VCardText>
        </UtilityCard>
      </v-dialog>
      <v-dialog v-model="dialog2" max-width="600px">
        <UtilityCard title="Ubah Data Sparepart">
            <VCardText>
                <VAlert
                v-if="sparepartError"
                v-html="sparepartError.message"
                :value="true"
                dismissible
                type="error"
                />
                <SparepartForm 
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
              v-if="sparepartLoading || sparepartError"
              class="text-xs-center"
            >
              <VAlert
                v-if="sparepartError"
                :value="true"
                dismissible
                type="sparepartError"
              >
              {{ sparepartError.message }}
              </VAlert>
              <VProgressCircular
                v-if="sparepartLoading"
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
import SparepartForm from '../../components/Form/SparepartForm'
import SparepartControl from '../../components/Renderless/SparepartControl'
import sparepartService from '../../service/Sparepart'
import { mapActions,mapState } from 'vuex';

export default {
  components: {
    SparepartControl,
    SparepartForm
  },
  data () {
    return {
      name: '',
      isFormValid: false,
      dialog: false,
      dialog2: false,
      warning: false,
      keyword: '',
      id_sparepart: '',
      headers: [
          {
            text: 'ID',
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
            text: 'Type',
            value: 'sparepart_type_name'
          },
          {
            text: 'Stock',
            value: 'stock'
          }, 
          {
            text: 'Min Stock',
            value: 'min_stock'
          },
          {
            text: 'Harga Beli',
            value: 'purchase_price'
          },
          {
            text: 'Harga Jual',
            value: 'sell_price'
          },
          {
            text: 'Penempatan',
            value: 'placement'
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
          text: 'Sparepart',
          disabled: true,
        },
      ]
    }
  },

  computed: {
    ...mapState({
      sparepartError: state => state.Sparepart.error,
      sparepartLoading: state => state.Sparepart.loading
    })
  },


  methods: {
    ...mapActions({
      deleteSparepart: 'Sparepart/delete',
      storeSparepart: 'Sparepart/store',
      resetForm: 'Sparepart/resetForm',
      updateSparepart: 'Sparepart/update',
      fetchSparepart: 'Sparepart/edit',
      update: 'Sparepart/updatesparepart',
    }),

    fetch () {
      this.$refs.sparepartControl.fetch()
    },

    async editHandler(id){
      console.log(id)
      this.id_sparepart=id
      await this.fetchSparepart(id)
      this.dialog2=true
    },

    deleteWarning(id){
        this.id_sparepart=id
        this.warning=true
    },

    async deleteHandler () {
      console.log(this.id_sparepart);
      await this.deleteSparepart(this.id_sparepart)
      this.fetch()
      this.warning=false
    },

    async submitHandler (value) {
      const payload1 = {
        sparepart_name: value.sparepart_name,
        image: value.image,
        merk: value.merk,
        id_sparepart: value.id_sparepart,
        stock: value.stock,
        min_stock: value.min_stock,
        purchase_price: value.purchase_price,
        sell_price: value.sell_price,
        placement: value.position + '-' + value.place + '-'+ value.number,
        id_sparepart_type: value.id_sparepart_type,
        motorcycleTypes: value.motorcycleTypes
      }
      
      console.log(value.motorcycleTypes)

      let payload = new FormData();
      payload.append('sparepart_name',value.sparepart_name)
      payload.append('image',value.image)
      payload.append('merk',value.merk)
      payload.append('id_sparepart',value.id_sparepart)
      payload.append('stock',value.stock)
      payload.append('min_stock',value.min_stock)
      payload.append('purchase_price',value.purchase_price)
      payload.append('sell_price',value.sell_price)
      payload.append('placement',value.position + '-' + value.place + '-'+ value.number)
      payload.append('id_sparepart_type',value.id_sparepart_type)
      payload.append('motorcycleTypes',value.motorcycleTypes)
      console.log(payload)

      await this.storeSparepart(payload)
    
      if (!this.sparepartError) {
        this.dialog=false
        this.fetch()
      }
    },

    async submitHandler2 (value) {
      
      console.log(this.id_sparepart);
      const payload = {
        id_sparepart: this.id_sparepart,
        image: value.image,
        sparepart_name: value.sparepart_name,
        merk: value.merk,
        stock: value.stock,
        min_stock: value.min_stock,
        purchase_price: value.purchase_price,
        sell_price: value.sell_price,
        placement: value.position + '-'+ value.place + '-'+ value.number,
        motorcycleTypes: value.motorcycleTypes,
        id_sparepart_type: value.id_sparepart_type
      }

      console.log(payload)

      await this.updateSparepart(payload)
    
      if (!this.sparepartError) {
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

  .warning-section {
    color: red;
    margin-right: 5px;
    font-style: italic;
  }
</style>


