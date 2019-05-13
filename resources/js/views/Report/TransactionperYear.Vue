<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
    <card>
      <v-container grid-list-md mb-0>
        <h1 class="text-md-center">PENJUALAN PERBULAN</h1>
      </v-container> 
      <v-layout row wrap>
        <v-flex xs6>
            <!-- <v-menu
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
                slot="activator"
                v-model="date"
                label="Birthday date"
                prepend-icon="event"
                readonly
            ></v-text-field>
            <v-date-picker
                ref="picker"
                v-model="date"
                @input="save"
                reactive
                no-title
            ></v-date-picker>
            </v-menu> -->
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
              <td v-html="props.item.Sparepart" />
              <td v-html="props.item.Service"/>
              <td v-html="props.item.Total"/>
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
      ]
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
        await this.printReport(2019);
    },

    async fetch () {
      await this.fetchReport(2019);
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


