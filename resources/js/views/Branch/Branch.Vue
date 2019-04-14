<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
    <card>
      <v-container grid-list-md mb-0>
        <h1 class="text-md-center">DATA CABANG</h1>
      </v-container> 
      <v-layout row wrap>
        <v-flex xs6>
            <VBtn
            depressed
            dark
            round
            color = "green accent-3"
            @click="dialog = true"
            >
            <VIcon>add</VIcon>
                Tambah Cabang
            </VBtn>
        </v-flex>
        <v-flex xs6 class="text-xs-right">
            <VBtn
            icon
            @click="fetch()"
            >
                <VIcon>refresh</VIcon>
            </VBtn>
            <CardSearchBar v-model="keyword" />
        </v-flex>
       </v-layout>
      <BranchControl ref="branchControl">
        <template slot-scope="{ loading, error, items }">
          <VCardText
            v-if="loading || error"
            class="text-xs-center"
          >
            <VAlert
              v-if="error"
              type="error"
              dismissible
              :value="true"
            >
              {{ error.message }}
            </VAlert>
            <VProgressCircular
              :size="45"
              indeterminate
              class="loading-section"
            />
          </VCardText>
          <VDataTable
            :headers="headers"
            :items="items"
            :search="keyword"
            v-if="!loading && !error"
          >
            <template slot="items" slot-scope="props">
              <td v-html="props.item.id_branch" />
              <td v-html="props.item.branch_name" />
              <td v-html="props.item.branch_address" />
              <td v-html="props.item.branch_phone_number" />
              <td class="text-xs-center">
                <VBtn 
                  flat
                  icon
                  color="indigo"
                  dark
                  @click="editHandler(props.item.id_branch)"
                >
                  <v-icon>edit</v-icon>
                </VBtn>
                <VBtn 
                  flat
                  icon
                  color="error"
                  dark
                  @click="deleteWarning(props.item.id_branch)"
                >
                  <v-icon>delete</v-icon>
                </VBtn>
              </td>
            </template>
          </VDataTable>
        </template>
      </BranchControl>
      <v-dialog v-model="dialog" max-width="600px">
        <UtilityCard title="Tambah Cabang">
            <VCardText>
                <VAlert
                v-if="branchError"
                v-html="branchError.message"
                :value="true"
                dismissible
                type="error"
                />
                <BranchForm 
                v-model="isFormValid"
                @submitted="submitHandler"
                />
            </VCardText>
        </UtilityCard>
      </v-dialog>
      <v-dialog v-model="dialog2" max-width="600px">
        <UtilityCard title="Ubah Data Cabang">
            <VCardText>
                <VAlert
                v-if="branchError"
                v-html="branchError.message"
                :value="true"
                dismissible
                type="error"
                />
                <BranchForm 
                v-model="isFormValid"
                @submitted="submitHandler2"  
                />
            </VCardText>
        </UtilityCard>
      </v-dialog>
      <v-dialog v-model="warning" persistent max-width="500">
        <v-card>
            <v-card-title class="headline">Warning!</v-card-title>
            <VCardText
              v-if="branchLoading || branchError"
              class="text-xs-center"
            >
              <VAlert
                v-if="branchError"
                :value="true"
                dismissible
                type="error"
              >
              {{ branchError.message }}
              </VAlert>
              <VProgressCircular
                v-if="branchLoading"
                :size="45"
                indeterminate
                class="loading-section"
              />
            </VCardText>
            <v-card-text v-else class="text-md-center" style="font-size:15px">Anda yakin ingin menghapus data ini?</v-card-text>
            <v-card-actions>
            <v-spacer/>
            <VBtn class="mb-4" depressed dark color="red accent-3" @click="warning = false">Disagree</VBtn>
            <VBtn class="mb-4" depressed dark color="green accent-3" @click="deleteHandler()">Agree</VBtn>
            <v-spacer/>
            </v-card-actions>
        </v-card>
      </v-dialog>
    </card>
  </PageWrapper>
</template>

<script>
import BranchForm from '../../components/Form/BranchForm'
import BranchControl from '../../components/Renderless/BranchControl'
import branchService from '../../service/Branch'
import { mapActions,mapState } from 'vuex';

export default {
  components: {
    BranchControl,
    BranchForm
  },
  data () {
    return {
      name: '',
      isFormValid: false,
      dialog: false,
      dialog2: false,
      warning: false,
      keyword: '',
      id_branch: '',
      headers: [
          {
            text: 'ID',
            value: 'id_branch',
          },
          {
            text: 'Nama',
            value: 'branch_name'
          },
          {
            text: 'Alamat',
            value: 'branch_address'
          },
          {
            text: 'Nomor Telepon',
            value: 'branch_phone_number'
          },
          {
            text: 'Aksi',
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
          text: 'Cabang',
          disabled: true,
        },
      ]
    }
  },

  computed: {
    ...mapState({
      branchError: state => state.Branch.error,
      branchLoading: state => state.Branch.loading
    })
  },


  methods: {
    ...mapActions({
      deleteBranch: 'Branch/delete',
      storeBranch: 'Branch/store',
      resetForm: 'Branch/resetForm',
      updateBranch: 'Branch/update',
      fetchBranch: 'Branch/edit',
    }),

    fetch () {
      this.$refs.branchControl.fetch()
    },

    async editHandler(id){
      this.id_branch=id
      await this.fetchBranch(id)
      this.dialog2=true
    },

    deleteWarning(id){
        this.id_branch=id
        this.warning=true
    },

    async deleteHandler () {
      console.log(this.id_branch);
      await this.deleteBranch(this.id_branch)
      this.fetch()
      this.warning=false
    },

    async submitHandler (value) {
      const payload = {
        branch_name: value.branch_name,
        branch_address: value.branch_address,
        branch_phone_number: value.branch_phone_number
      }

      await this.storeBranch(payload)
    
      if (!this.branchError) {
        this.dialog=false
        this.fetch()
      }
    },

    async submitHandler2 (value) {
      console.log(this.id_branch);
      const payload = {
        id_branch: this.id_branch,
        branch_name: value.branch_name,
        branch_address: value.branch_address,
        branch_phone_number: value.branch_phone_number
      }

      await this.updateBranch(payload)
    
      if (!this.branchError) {
        this.dialog2=false
        this.fetch()
      }
    },
  },

  mounted () {
    this.resetForm()
  }
}
</script>

<style scoped>
.loading-section {
  text-align: center;
}
</style>


