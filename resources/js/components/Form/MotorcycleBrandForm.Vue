<template>
  <VForm>
    <VLayout>
      <VFlex>
        <VTextField
          label="Nama"
          class="pa-1"
          v-model="form.motorcycle_brand_name"
          :error-messages="nameErrors"
          @input="$v.form.motorcycle_brand_name.$touch()"
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
import validator from '../../validations/motorcycleBrandValidation'
import { mapGetters } from 'vuex'

export default {
  props: {
    value: {
      type: Boolean,
      default: false
    }
  },

  computed: {
    ...mapGetters({
      form: 'MotorcycleBrand/motorcycleBrand'
    }),
    
    nameErrors () {
      const errors = []

      if (!this.$v.form.motorcycle_brand_name.$invalid) return errors
      
      if (!this.$v.form.motorcycle_brand_name.required && this.$v.form.motorcycle_brand_name.$dirty) {
        errors.push('Inputan nama tidak valid')
      }

      return errors
    },

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
