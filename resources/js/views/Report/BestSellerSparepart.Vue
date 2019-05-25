<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
    <card>
      <v-container grid-list-md mb-0>
        <h1 class="text-md-center">SPAREPART TERLARIS</h1>
      </v-container> 
      <v-layout row wrap>
        <v-flex xs6>
        </v-flex>
        <v-flex xs6 class="text-xs-right">
            <VBtn
            depressed
            dark
            round
            color = "green accent-3"
            @click="print()"
            >
            <VIcon>print</VIcon>
                Print
            </VBtn>
            <VBtn
            icon
            @click="fetch()"
            >
                <VIcon>refresh</VIcon>
            </VBtn>
            <CardSearchBar v-model="keyword" />
        </v-flex>
       </v-layout>
          <VDataTable
            :headers="headers"
            :items="reports"
            :search="keyword"
            v-if="!loading && !error"
          >
            <template slot="items" slot-scope="props">
              <td v-html="props.item.Bulan" />
              <td v-html="props.item.NamaBarang" />
              <td v-html="props.item.TipeBarang"/>
              <td v-html="props.item.JumlahPenjualan"/>
            </template>
          </VDataTable>
    </card>
  </PageWrapper>
</template>

<script>
import { mapActions,mapState } from 'vuex';

export default {
  data () {
    return {
      name: '',
      date: null,   
      menu: false,
      isFormValid: false,
      dialog: false,
      dialog2: false,
      warning: false,
      keyword: '',
      id_service: '',
      headers: [
          {
            text: 'Bulan',
            value: 'service_name'
          },
          {
            text: 'Nama Barang',
            value: 'price'
          },
          {
            text: 'Tipe Barang',
            value: null
          },
          {
            text: 'Jumlah Penjualan',
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
          text: 'TransactionPerMonth',
          disabled: true,
        },
      ],
    }
  },

  watch: {
    menu (val) {
      val && this.$nextTick(() => (this.$refs.picker.activePicker = 'YEAR'))
    }
  },

  computed: {
    ...mapState({
      reports: state => state.Report.reports,
      Error: state => state.Report.error,
      Loading: state => state.Report.loading
    })
  },


  methods: {
    ...mapActions({
      fetchReport: 'Report/bestSellerSparepart',
      printReport: 'Report/printBestSellerSparepart'
    }),

    async print(){
        // await this.printReport();
        window.open(`/api/generate-sparepart-best-seller`, '_blank')
    },

    async fetch () {
      await this.fetchReport();

    //   this.reports.forEach(report => {
    //       this.series[0].data.push(report.Sparepart)
    //       this.series[1].data.push(report.Service)
    //       this.series[2].data.push(report.Total)
    //   });
    },
    save (date) {
      this.$refs.menu.save(date);
      this.$refs.picker.activePicker = 'YEAR'
      this.menu = false;
    }
  },

  mounted () {
    this.fetch()
  }
}
</script>

<style scoped>
.loading-section {
  text-align: center;
}
</style>


