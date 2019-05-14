<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
    <card>
      <v-container grid-list-md mb-0>
        <h1 class="text-md-center">LAPORAN SISA STOCK</h1>
      </v-container> 
      <v-layout row wrap>
        <v-flex xs3>
            <v-menu
              ref="menu"
              :close-on-content-click="false"
              v-model="menu"
              :nudge-right="40"
              lazy
              transition="scale-transition"
              offset-y
              full-width
              min-width="290px"
            >
              <v-text-field
                class="ml-3"
                slot="activator"
                v-model="year"
                label="Tahun"
                readonly
              ></v-text-field>
              <v-date-picker
                ref="picker"
                v-model="date"
                @input="save"
                reactive
                no-title
              ></v-date-picker>
            </v-menu>
        </v-flex>
        <v-flex xs3>
            <v-select
            label="Sparepart type"
            class="ml-3"
            v-model="sparepart_type"
            item-text="sparepart_type_name"
            item-value="id_sparepart_type"
            :items="items"
            @change="fetch()"
            required
          ></v-select>
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
              <td v-html="props.item.JumlahStokSisa" />
            </template>
          </VDataTable>
          <v-container grid-list-md mb-0>
            <h1 class="text-md-center">CHART SISA STOCK</h1>
          </v-container> 
          <v-layout row wrap>
              <v-flex xs4 class="text-xs-right">

              </v-flex>
              <v-flex xs4 class="text-xs-center">
                  <apexchart type=pie width=100% :options="chartOptions" :series="series" />
              </v-flex>
              <v-flex xs4 class="text-xs-right">

              </v-flex>
                
          </v-layout>
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
      year: new Date().getFullYear(),
      sparepart_type: 1,
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
            text: 'Sisa Stock',
            value: 'price'
          },
      ],
      breadcrumbs: [
        {
          text: 'Dashboard',
          to: { name: 'dashboard' },
          exact: true,
        },
        {
          text: 'RemainingStock',
          disabled: true,
        },
      ],
      series: [],
        chartOptions: {
            labels: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
            responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                width: 200
                },
                legend: {
                position: 'bottom'
                }
            }
        }]
    }
    }
  },

  watch: {
    menu (val) {
      val && this.$nextTick(() => (this.$refs.picker.activePicker = 'YEAR'))
    }
  },

  computed: {
    ...mapState({
      items: state => state.SparepartType.sparepartTypes,
      reports: state => state.Report.reports,
      Error: state => state.Report.error,
      Loading: state => state.Report.loading
    })
  },


  methods: {
    ...mapActions({
      fetchType: 'SparepartType/get',
      fetchReport: 'Report/remainingStock',
      printReport: 'Report/printTransactionperMonth'
    }),

    async print(){
        await this.printReport(this.year);
    },

    async fetch () {

      const payload = {
            year: this.year,
            sparepart: this.sparepart_type,
      }
  
      await this.fetchReport(payload);
      this.series=[]
    
      this.reports.forEach(report => {
          this.series.push(report.JumlahStokSisa)
      });
    },
    async save (date) {
      this.$refs.menu.save(date);
      this.$refs.picker.activePicker = 'YEAR'
      var name = this.date;
      var word = name.split('-');
      this.year=word[0]
      this.menu = false;
    
    //   this.series[0].data=[]
    //   this.series[1].data=[]
    //   this.series[2].data=[]
    //   this.reports.forEach(report => {
    //       this.series[0].data.push(report.Sparepart)
    //       this.series[1].data.push(report.Service)
    //       this.series[2].data.push(report.Total)
    //   });
    }
  },

  async mounted () {
    this.fetch()
    await this.fetchType()
  }
}
</script>

<style scoped>
.loading-section {
  text-align: center;
}
</style>


