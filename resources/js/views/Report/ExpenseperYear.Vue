<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
    <card>
      <v-container grid-list-md mb-0>
        <h1 class="text-md-center">PENGELUARAN BULANAN</h1>
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
              <td v-html="props.item.Total"/>
            </template>
          </VDataTable>
          <v-container grid-list-md mb-0>
            <h1 class="text-md-center">CHART PENJUALAN BULANAN</h1>
          </v-container> 
           <v-layout row wrap>
              <v-flex xs12 sm12 class="text-xs-center">
                  <apexchart type=pie height="300" :options="chartOptions" :series="series" />
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
            text: 'Jumlah Pengeluaran',
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
      reports: state => state.Report.reports,
      Error: state => state.Report.error,
      Loading: state => state.Report.loading
    })
  },


  methods: {
    ...mapActions({
      fetchReport: 'Report/expenseperYear',
      printReport: 'Report/printExpenseperYear'
    }),

    async print(){
        // await this.printReport(this.year);
        window.open(`/api/generate-expense/${this.year}`, '_blank')
    },

    async fetch () {
      await this.fetchReport(this.year);
      this.series=[]
    
      this.reports.forEach(report => {
          this.series.push(report.Total)
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
      this.series=[]
    
      this.reports.forEach(report => {
          this.series.push(report.Total)
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


