<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
    <card>
      <v-container grid-list-md mb-0>
        <h1 class="text-md-center">PENJUALAN PERBULAN</h1>
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
        <v-flex xs9 class="text-xs-right">
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
              <td v-html="props.item.Sparepart" />
              <td v-html="props.item.Service"/>
              <td v-html="props.item.Total"/>
            </template>
          </VDataTable>
          <v-container grid-list-md mb-0>
            <h1 class="text-md-center">CHART PENJUALAN BULANAN</h1>
          </v-container> 
          <v-layout row wrap>
                <apexchart width="100%" type="bar" :options="chartOptions" :series="series"></apexchart>
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
            text: 'Service',
            value: 'price'
          },
          {
            text: 'Spareparts',
            value: null
          },
          {
            text: 'Total',
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
      series: [{
          name: 'Sparepart',
          data: []
        }, {
          name: 'Service',
          data: []
        }, {
          name: 'Total',
          data: []
        }],
        chartOptions: {
          plotOptions: {
            bar: {
              horizontal: false,
              columnWidth: '55%',
              endingShape: 'rounded'	
            },
          },
          dataLabels: {
            enabled: false
          },
          stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
          },

          xaxis: {
            categories: ['Jan','Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct','Nov','Dec'],
          },
          yaxis: {
            title: {
              text: 'Rp '
            }
          },
          fill: {
            opacity: 1

          },
          tooltip: {
            y: {
              formatter: function (val) {
                return "Rp " + val + " "
              }
            }
          }
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
      reports: state => state.Report.reports,
      Error: state => state.Report.error,
      Loading: state => state.Report.loading
    })
  },


  methods: {
    ...mapActions({
      fetchReport: 'Report/transactionperYear',
      printReport: 'Report/printTransactionperMonth'
    }),

    async print(){
        await this.printReport(this.year);
    },

    async fetch () {
      await this.fetchReport(this.year);
      this.series[0].data=[]
      this.series[1].data=[]
      this.series[2].data=[]
      this.reports.forEach(report => {
          this.series[0].data.push(report.Sparepart)
          this.series[1].data.push(report.Service)
          this.series[2].data.push(report.Total)
      });
    },
    async save (date) {
      this.$refs.menu.save(date);
      this.$refs.picker.activePicker = 'YEAR'
      var name = this.date;
      var word = name.split('-');
      this.year=word[0]
      this.menu = false;
      
      await this.fetchReport(this.year);
      this.series[0].data=[]
      this.series[1].data=[]
      this.series[2].data=[]
      this.reports.forEach(report => {
          this.series[0].data.push(report.Sparepart)
          this.series[1].data.push(report.Service)
          this.series[2].data.push(report.Total)
      });
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


