<template>
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
</template>

<script>
import BranchForm from '../../components/Form/BranchForm'
import { mapActions, mapState } from 'vuex'

export default {
  components: {
    BranchForm,
  },

  data () {
    return {
      name: '',
      isFormValid: false,
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
      storeBranch: 'Branch/store',
      resetForm: 'Branch/resetForm'
    }),

    async submitHandler (value) {
      const payload = {
        branch_name: value.branch_name,
        branch_address: value.branch_address,
        branch_phone_number: value.branch_phone_number
      }

      await this.storeBranch(payload)
    
      if (!this.branchError) {
        this.$emit('close');
      }
    },
  },

  mounted () {
    this.resetForm()
  }
}
</script>