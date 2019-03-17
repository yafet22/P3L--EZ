<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
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
          @submitted="submitHandler"  
        />
      </VCardText>
    </UtilityCard>
  </PageWrapper>
</template>

<script>
import BranchForm from '../../components/Form/BranchForm'
import { mapActions, mapState } from 'vuex'

export default {
  components: {
    BranchForm,
  },

  computed: {
    ...mapState({
      branchError: state => state.Branch.error,
      branchLoading: state => state.Branch.loading
    })
  },

  data () {
    return {
      
    }
  },

  methods: {
    ...mapActions({
      fetchBranch: 'Branch/edit',
      updateBranch: 'Branch/update',
    }),

    async submitHandler (value) {
      const payload = {
        id: this.$route.params.id,
        name: value.name,
        address: value.address,
        phoneNumber: value.phoneNumber
      }

      await this.updateBranch(payload)

      if (!this.branchError) {
        return this.$router.push({ name: 'branches.index' })
      }
    }
  },

  async mounted () {
    await this.fetchBranch(this.$route.params.id)
  }
}
</script>

