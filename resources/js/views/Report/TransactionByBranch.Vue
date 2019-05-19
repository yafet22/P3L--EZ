<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
    <card>
      <v-container grid-list-md mb-0>
        <h1 class="text-md-center">LAPORAN PENDAPATAN TAHUNAN</h1>
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
              <td v-html="props.item.Tahun" />
              <td v-html="props.item.Cabang" />
              <td v-html="props.item.Total"/>
            </template>
          </VDataTable>
          <v-container grid-list-md mb-0>
            <h1 class="text-md-center">CHART PENJUALAN TAHUNAN</h1>
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
      isFormValid: false,
      dialog: false,
      dialog2: false,
      warning: false,
      keyword: '',
      id_service: '',
      index: 0,
      headers: [
          {
            text: 'Tahun',
            value: 'service_name'
          },
          {
            text: 'Cabang',
            value: 'price'
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
      data :{
          name:'',
          data: []
      },
      data2 :{
          name:'',
          data: []
      },
      series: [
        // {
        //   name: 'Sparepart',
        //   data: []
        // }, {
        //   name: 'Service',
        //   data: []
        // }
        ],
        chartOptions: {
          plotOptions: {
            bar: {
              horizontal: false,
              columnWidth: '5%',
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
            categories: [],
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
      fetchReport: 'Report/transactionByBranch',
      printReport: 'Report/printTransactionbyBranch'
    }),

    async print(){
        await this.printReport();
    },

    async fetch () {
      await this.fetchReport();
      this.series=[]
      this.reports.forEach(report => {
          console.log("cek")
         if(this.series.length!=0)
         {
             console.log("masuk1")
             this.series.forEach(item => {
                if(report.Cabang!=item.name)
                {
                    console.log("yaa")
                    this.index=this.index+1
                    console.log(report.Cabang)
                    this.data2.name=report.Cabang
                    this.series.push(this.data2)
                }     
            });
         }
         else
         {
             console.log("masuk2")
             this.index=this.index+1
             this.data.name=report.Cabang
             console.log(report.Cabang)
             this.series.push(this.data)
         }
         if(this.chartOptions.xaxis.categories!=0)
         {
             this.chartOptions.xaxis.categories.forEach(item => {
                if(!report.Tahun==item)
                {
                    this.chartOptions.xaxis.categories.push(report.Tahun)
                }     
            });
         }
         else
         {
             this.chartOptions.xaxis.categories.push(report.Tahun)
         }
      });
      this.reports.forEach(report => {
        this.series.forEach(item => {
            console.log(item.name)
            if(report.Cabang==item.name)
            {
                console.log("dwdw")
                item.data.push(report.Total)   
            }
        });
      });
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


