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
                    <v-form>
                      <v-text-field prepend-icon="person" name="username" label="Username" type="text"></v-text-field>
                      <v-text-field prepend-icon="lock" name="password" label="Password" id="password" type="password"></v-text-field>
                    </v-form>
                    <v-card-actions class="mt-2">
                      <v-spacer></v-spacer>
                      <v-btn color="success">Login</v-btn>
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
                    <img src="http://localhost:8000/asset/logo.png" style="height:180px">
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

</script>

<style>
 .jumbotron {
   min-height: 400px;
   width: 100%;
   background-color:#3F51B5;
   color: white;
 }
</style>





