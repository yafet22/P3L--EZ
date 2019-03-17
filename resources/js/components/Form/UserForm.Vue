<template>
  <VForm>
    <VLayout>
      <VFlex>
        <VTextField
          label="Username"
          class="pa-1"
          v-model="form.username"
          :error-messages="usernameErrors"
          @input="$v.form.username.$touch()"
          required
        />
      </VFlex>
    </VLayout>
    <VLayout>
      <VFlex>
        <VTextField
          label="Password"
          class="pa-1"
          v-model="form.password"
          :error-messages="passwordErrors"
          @input="$v.form.password.$touch()"
          required
        />
      </VFlex>
    </VLayout>
    <VSpacer />
    <VLayout>
      <VFlex
        class="text-xs-center"
      >
        <VBtn
          depressed
          color="success"
          @click="submitHandler"
          :disabled="!this.value"
        >
          Kirim
        </VBtn>
      </VFlex>
    </VLayout>
  </VForm>
</template>

<script>
import validator from '../../validations/userValidation'
import { mapGetters,mapState, mapActions } from 'vuex'

export default {
  props: {
    value: {
      type: Boolean,
      default: false
    }
  },

  computed: {
    ...mapGetters({
      form: 'User/user'
    }),
    
    usernameErrors () {
      const errors = []

      if (!this.$v.form.username.$invalid) return errors
      
      if (!this.$v.form.username.required && this.$v.form.username.$dirty) {
        errors.push('Inputan username tidak valid')
      }

      return errors
    },

    passwordErrors () {
      const errors = []

      if (!this.$v.form.password.$invalid) return errors 

      if (!this.$v.form.password.numeric && this.$v.form.password.$dirty) {
        errors.push('Inputan password tidak valid')
      }

      return errors
    }
  },

  validations: validator,

  watch: {
    form: {
      deep: true,
      handler () {
        this.$emit('input', !this.$v.form.$invalid)
      }
    }    
  },

  methods: {
    submitHandler () {
      this.$emit('submitted', this.form)
    }
  }
}
</script>
