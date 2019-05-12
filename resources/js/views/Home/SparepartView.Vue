<template>
  <div id="app">
   <v-app light>
    <v-toolbar color="blue-grey darken-4">
      <v-toolbar-title v-text="title" class="white--text"></v-toolbar-title>
      <VSpacer />

      <VToolbarItems>
        <VBtn
          v-for="menu in menus" 
          :key="menu.id"
          flat
          dark
          @click="$router.push({ name: menu.to })"
        >
          {{ menu.text }}
        </VBtn>
      </VToolbarItems>
    </v-toolbar>
    <v-content>
      <section>
        <VContainer>        
          <VDataIterator
              :items="initsparepart"
              :rows-per-page-items="rowsPerPageItems"
              :search="search"
              content-tag="v-layout"
              row
              wrap
          >
              <template v-slot:header>
                <v-layout class="mb-2">
                  <v-flex sm9>
                    <v-text-field
                    append-icon="search"
                    v-model="search"
                    flat
                    light
                    label="Cari Sparepart"
                    solo-inverted
                  ></v-text-field>
                  <!-- <v-autocomplete
                    append-icon="search"
                    v-model="select"
                    :loading="loading"
                    :items="items"
                    :search-input.sync="search"
                    cache-items                      
                    light
                    hide-no-data
                    hide-details
                    placeholder="Cari Sparepart"
                  ></v-autocomplete> -->
                  </v-flex>
                  <v-flex sm3>
                    <v-btn flat
                      v-if="sortPrice=='asc' || sortPrice=='none'"
                      @click="sortPrice='dsc',sortStock='none'"
                    >
                      <v-icon left>arrow_drop_up</v-icon>
                      harga
                    </v-btn>
                    <v-btn flat
                      v-else
                      @click="sortPrice='asc',sortStock='none'"
                    >
                      <v-icon left>arrow_drop_down</v-icon>
                      harga
                    </v-btn>
                    <v-btn flat
                      v-if="sortStock=='asc' || sortStock=='none'"
                      @click="sortStock='dsc',sortPrice='none'"
                    >
                      <v-icon left>arrow_drop_up</v-icon>
                      stock
                    </v-btn>
                    <v-btn flat
                      v-else
                      @click="sortStock='asc',sortPrice='none'"
                    >
                      <v-icon left>arrow_drop_down</v-icon>
                      stock
                    </v-btn>
                  </v-flex>
                </v-layout>
                
              </template>

              <template v-slot:item="props">
              <VFlex
              class="pa-1"
              md3
              >
              <VCard>
                  <VImg
                  :src="'/images/'+props.item.image"
                  :height="280"
                  :width="276"
                  >
                    <v-layout
                      fill-height
                      wrap
                      text-xs-right
                      ma-0
                  >
                      <v-flex xs12>
                          <v-chip
                          label
                          class="mx-0 mb-2 text-uppercase"
                          color="grey darken-3"
                          text-color="white"
                          small
                          @click.stop=""
                          >
                          {{ props.item.sparepart_name }}
                          </v-chip>
                          <!-- <h3 class="title font-weight-bold mb-2">
                          {{ props.item.sparepart_name }}
                          </h3>
                          <div class="caption">
                          {{ props.item.sparepart_name }}<br>Date
                          </div> -->
                      </v-flex>
                    </v-layout>
                  </VImg>
                  <VCardTitle  primary-title class="headline layout justify-center">
                  {{ props.item.sparepart_name }}
                  </VCardTitle>
                  <VDivider />
                  <VCardText class="layout justify-center">
                  Jumlah Stok Tersedia : {{ props.item.stock }} <br>
                  Harga : {{ props.item.sell_price }}
                  </VCardText>
              </VCard>
              </VFlex>
              </template>
          </VDataIterator>
        </VContainer>
      </section>

      <section class="blue-grey darken-4 white--text">
        <v-container grid-list-xl>
          <v-layout row wrap justify-center class="my-5 white--text">
            <v-flex xs12 sm4>
              <v-card class="elevation-0 transparent">
                <v-card-title primary-title class="layout justify-center white--text">
                  <div class="headline">Tentang Kami</div>
                </v-card-title>
                <v-card-text class="white--text">
                  Atma Auto adalah sebuah bengkel sepeda motor yang menyediakan jasa service dan penjualan  spareparts  yang berada  di  Kota  Yogyakarta. Atma  Auto  menyediakan  spareparts motor  dari  berbagai  merk  sepeda  motor  yang  ada  di  Indonesia.  Selain  menjual  spareparts, Atma  Auto  juga  menyediakan  beberapa  jasa  service  pada  sepeda  motor.
                </v-card-text>
              </v-card>
            </v-flex>
            <v-flex xs12 sm4 offset-sm1>
              <v-card class="elevation-0 transparent">
                <v-card-title primary-title class="layout justify-center white--text">
                  <div class="headline">Hubungi Kami</div>
                </v-card-title>
      
                <v-list class="transparent">
                  <v-list-tile>
                    <v-list-tile-action>
                      <v-icon class="blue--text text--lighten-2">phone</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content class="white--text">
                      <v-list-tile-title>0215527557</v-list-tile-title>
                    </v-list-tile-content>
                  </v-list-tile>
                  <v-list-tile>
                    <v-list-tile-action>
                      <v-icon class="blue--text text--lighten-2">place</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content class="white--text">
                      <v-list-tile-title>Yogyakarta, Indonesia</v-list-tile-title>
                    </v-list-tile-content>
                  </v-list-tile>
                  <v-list-tile>
                    <v-list-tile-action>
                      <v-icon class="blue--text text--lighten-2">email</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content class="white--text">
                      <v-list-tile-title>atmauto@gmail.com</v-list-tile-title>
                    </v-list-tile-content>
                  </v-list-tile>
                </v-list>
              </v-card>
            </v-flex>
          </v-layout>
        </v-container>
      </section>

      <v-footer class="blue darken-2">
        <v-layout row wrap align-center>
          <v-flex xs12>
            <div class="white--text ml-3">
              Made with
              <v-icon class="red--text">favorite</v-icon>
              by <a class="white--text" target="_blank">Yafet</a>,
               <a class="white--text" target="_blank">Ryan</a>
              and <a class="white--text">Panda</a>
            </div>
          </v-flex>
        </v-layout>
      </v-footer>
    </v-content>
  </v-app>
 </div>
</template>

<script>
import SparepartControl from '../../components/Renderless/SparepartControl'
import { mapActions,mapState } from 'vuex';

export default {
    components: {
        SparepartControl
    },
    data () {
        return {
            title: 'ATMA AUTO',
            menus: [
                {
                id: 1,
                to: 'home',
                text: 'Home'
                },
                {
                id: 2,
                to: '',
                text: 'Sparepart'
                },
                {
                id: 3,
                to: 'customer.motor',
                text: 'Cek Status'
                },
            ],
            sortPrice: 'none',   
            sortStock: 'none',
            search: '',  
            select: '',
            rowsPerPageItems: [8, 16, 24, 32],
      }
    },

    computed: {
      ...mapState({
        spareparts: state => state.Sparepart.spareparts,
        sparepartError: state => state.Sparepart.error,
        sparepartLoading: state => state.Sparepart.loading,
      }),

      initsparepart(){
          if(this.sortPrice=='none' && this.sortStock=='none')
          {
              return this.spareparts
          }
          else if(this.sortPrice=='asc'){
              var sparepartData =  this.spareparts.sort(function(obj1, obj2) {
                                          // Ascending: first age less than the previous
                                          return obj2.sell_price - obj1.sell_price;
                                      });
                                      
              return sparepartData
          }
          else if(this.sortPrice=='dsc'){
              var sparepartData =  this.spareparts.sort(function(obj1, obj2) {
                                          // Ascending: first age less than the previous
                                          return obj1.sell_price - obj2.sell_price;
                                      });
              return sparepartData
          }
          else if(this.sortStock=='asc'){
              var sparepartData =  this.spareparts.sort(function(obj1, obj2) {
                                          // Ascending: first age less than the previous
                                          return obj2.stock - obj1.stock;
                                      });
              return sparepartData
          }
          else if(this.sortStock=='dsc'){
              var sparepartData =  this.spareparts.sort(function(obj1, obj2) {
                                          // Ascending: first age less than the previous
                                          return obj1.stock - obj2.stock;
                                      });
              return sparepartData
          }

      },

      getSpareparts() {
      
        var spareparts = this.spareparts.filter((sparepart) => {
            return sparepart.sparepart_name.toLowerCase().includes(this.search.toLowerCase());
          });
        
        if (this.descPrice == true) {
          return spareparts.sort(function(a, b) {
            return b.sparepart_name - a.sparepart_name
          });
        } else {
          return spareparts;
        }
        
      },

      filteredItems(){
          var spareparts = this.spareparts.filter((sparepart) => {
            return sparepart.sparepart_name.includes(this.select);
          });
      },

      filtered(){
        let filter = this.spareparts.filter( b => b.sparepart_name === this.select)
        return filter
    },

    },

    methods: {
      ...mapActions({
        fetch: 'Sparepart/get' 
      }),
    },

    mounted () {
      this.fetch()
    }
      
  }
</script>

<style>
 .jumbotron {
   min-height: 400px;
   width: 100%;
   background-color:#3F51B5;
   color: white;
 }
</style>





