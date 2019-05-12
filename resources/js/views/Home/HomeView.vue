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
        <v-parallax src="assets/bmw.jpg" height="600">
          <v-layout
            column
            align-center
            justify-center
            class="white--text"
          >
            <img src="asset/logo2.png" alt="Vuetify.js" height="200">
            <h1 class="white--text mb-2 display-1 text-xs-center">Atma Auto</h1>
            <div class="subheading mb-3 text-xs-center">Powered by SIBAAU</div>

            <v-btn
              class="light-blue darken-4 mt-5"
              dark
              large
              :to="{ name: 'customer.motor' }"
            >
              Cek Status Motor
            </v-btn>
          </v-layout>
        </v-parallax>
      </section>

      <section>
        <v-layout
          column
          wrap
          class="blue-grey darken-4 white--text"
          align-center
        >
          <v-flex xs12 sm4 class="mt-5 ">
            <div class="text-xs-center">
              <h2 class="headline">Bengkel Motor Terbaik</h2>
              <span class="subheading">
                Melayani dengan setulus hati 
              </span>
            </div>
          </v-flex>
          <v-flex xs12 mb-3>
            <v-container grid-list-xl>
              <v-layout row wrap align-center>
                <v-flex xs12 md4>
                  <v-card class="elevation-0 transparent white--text">
                    <v-card-text class="text-xs-center">
                      <v-icon x-large class="blue--text text--lighten-2">motorcycle</v-icon>
                    </v-card-text>
                    <v-card-title primary-title class="layout justify-center">
                      <div class="headline text-xs-center">Melayani Service Motor</div>
                    </v-card-title>
                    <v-card-text>
                      Pengerjaan service motor dikerjakan oleh para mechanic handal
                    </v-card-text>
                  </v-card>
                </v-flex>
                <v-flex xs12 md4>
                  <v-card class="elevation-0 transparent white--text">
                    <v-card-text class="text-xs-center">
                      <v-icon x-large class="blue--text text--lighten-2">flash_on</v-icon>
                    </v-card-text>
                    <v-card-title primary-title class="layout justify-center">
                      <div class="headline">Pelayanan Cepat</div>
                    </v-card-title>
                    <v-card-text class="justify">
                      Proses pengerjaan cepat serta dapat dipantau dengan mudah dan cepat
                    </v-card-text>
                  </v-card>
                </v-flex>
                <v-flex xs12 md4>
                  <v-card class="elevation-0 transparent white--text">
                    <v-card-text class="text-xs-center">
                      <v-icon x-large class="blue--text text--lighten-2">build</v-icon>
                    </v-card-text>
                    <v-card-title primary-title class="layout justify-center">
                      <div class="headline text-xs-center">Menjual Berbagai Sparepart</div>
                    </v-card-title>
                    <v-card-text>
                      Menyediakan berbagai sparepart dengan harga yang murah
                    </v-card-text>
                  </v-card>
                </v-flex>
              </v-layout>
            </v-container>
          </v-flex>
        </v-layout>
      </section>

      <section>
        <v-parallax src="assets/coba.jpg" height="380">
          <v-layout column align-center justify-center>
            <div class="headline white--text mb-3 text-xs-center">Sparepart Termurah dan Terlengkap</div>
            <em>Cek Ketersediaan Sparepart disini</em>
            <v-btn
              class="light-blue darken-4 mt-5"
              dark
              large
              :to="{ name: 'customer.sparepart' }"
            >
              Cek Sparepart
            </v-btn>
          </v-layout>
        </v-parallax>
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
  export default {
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
           to: 'customer.sparepart',
           text: 'Sparepart'
         },
         {
           id: 3,
           to: 'customer.motor',
           text: 'Cek Status'
         },
       ]
      }
    },

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





