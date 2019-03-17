<template>
  <v-container fluid fill-height>
    <v-layout align-center>
      <v-flex xs12 sm6 offset-sm3>
        <v-card>
          <v-layout >
            <v-flex xs6 order-lg2>
              <v-card height="100%">
                <v-container>
                    <v-card-title primary-title class="justify-center">
                      <div>
                        <h3 class="headline mb-0">Silahkan Login Terlebih Dahulu</h3>
                      </div>
                    </v-card-title>
                    <ErrorAlert ref="errorAlert" />
                    <v-form @submit.prevent="loginHandler()">
                      <v-text-field prepend-icon="person" name="username" label="Username" required type="text" v-model="form.username"></v-text-field>
                      <v-text-field prepend-icon="lock" name="password" label="Password" required id="password" type="password" v-model="form.password"></v-text-field>
                    </v-form>
                    <v-card-actions class="mt-2">
                      <v-spacer></v-spacer>
                      <v-btn 
                        color="success" 
                        @click="loginHandler"
                        type="submit"
                      >
                      Login
                      </v-btn>
                      <v-spacer></v-spacer>
                    </v-card-actions>
                </v-container>
              </v-card>
            </v-flex>
            <v-flex xs6>
              <v-card height="100%" color="primary">
                  <v-card-title 
                  primary-title 
                  class="justify-center">      
                    <h1 class="display-1 font-weight-medium white--text">SELAMAT DATANG</h1>
                    <h1 class="display-1 font-weight-medium white--text">DI SIBAAU LOGIN PANEL</h1>
                  </v-card-title>
                  <v-layout align-center justify-center>
                    <img src="http://localhost:8000/asset/logo2.png" style="height:180px">
                  </v-layout>                                
                <v-card-text fill-height> </v-card-text>
              </v-card>
            </v-flex>
          </v-layout>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
  import auth from '../../service/Auth'
  export default {
    name: 'LoginView',

    data () {
      return {
        form: {
          username: '',
          password: ''
        },
      }
    },

    watch: {
      form: {
        deep: true,
        handler (val) {
          this.$refs.errorAlert.reset()
        }
      }
    },

    methods: {
      async loginHandler(){
        try {
          await auth.authenticate(this.form)
          this.$router.push({ name: 'dashboard' })
        } catch (err) {
          this.$refs.errorAlert.trigger({ message: 'Terjadi Kesalahan Login!' })
        }
      }
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





