<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
    <card>
      <v-container grid-list-md mb-0>
        <h1 class="text-md-center">PENJUALAN JASA</h1>
      </v-container> 
      <v-layout row wrap>
        <v-flex xs3>
            <v-menu
                class="ml-3"
                ref="menu"
                v-model="menu"
                :close-on-content-click="false"
                :nudge-right="40"
                :return-value.sync="date"
                lazy
                transition="scale-transition"
                offset-y
                full-width
                @change="fetch()"
                max-width="290px"
                min-width="290px"
            >
                <template v-slot:activator="{ on }">
                <v-text-field
                     class="ml-3"
                    v-model="date"
                    label="Bulan dan Tahun"
                    readonly
                    v-on="on"
                    @change="fetch()"
                ></v-text-field>
                </template>
                <v-date-picker
                v-model="date"
                @change="fetch()"
                type="month"
                no-title
                scrollable
                >
                <v-spacer></v-spacer>
                <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
                <v-btn flat color="primary" @click="$refs.menu.save(date)">OK</v-btn>
                </v-date-picker>
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
              <td v-html="props.item.motorcycle_brand_name" />
              <td v-html="props.item.motorcycle_type_name" />
              <td v-html="props.item.service_name"/>
              <td v-html="props.item.jumlah_jasa"/>
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
      date: new Date().toISOString().substr(0, 7),
      menu: false,
      modal: false,
      isFormValid: false,
      dialog: false,
      dialog2: false,
      warning: false,
      keyword: '',
      id_service: '',
      headers: [
          {
            text: 'Merk',
            value: 'service_name'
          },
          {
            text: 'Tipe Motor',
            value: 'price'
          },
          {
            text: 'Nama Service',
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
      fetchReport: 'Report/serviceSelling',
      printReport: 'Report/printServiceSelling'
    }),

    async print(){
        var name = this.date;
        var word = name.split('-');

        const payload = {
                year: word[0],
                month: word[1],
        }
        // await this.printReport(payload);
        window.open(`/api/generate-service-selling/${word[0]}/${word[1]}`, '_blank')
    },

    async fetch () {
      var name = this.date;
      var word = name.split('-');

      const payload = {
            year: word[0],
            month: word[1],
      }
      await this.fetchReport(payload);

    //   this.reports.forEach(report => {
    //       this.series[0].data.push(report.Sparepart)
    //       this.series[1].data.push(report.Service)
    //       this.series[2].data.push(report.Total)
    //   });
    },

    async fetchData(){
        var name = this.date;
        var word = name.split('-');

        const payload = {
          year: word[0],
          month: word[1],
        }

        await this.fetchReport(payload);
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


