<template>
  <VForm>
    <VLayout>
      <VFlex>
        <VTextField
          label="Nama"
          class="pa-1"
          v-model="form.service_name"
          :error-messages="nameErrors"
          @input="$v.form.service_name.$touch()"
          required
        />
      </VFlex>
    </VLayout>
    <VLayout>
      <VFlex>
        <VTextField
          label="Harga"
          class="pa-1"
          v-model="form.price"
          :error-messages="priceErrors"
          @input="$v.form.price.$touch()"
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
import validator from '../../validations/serviceValidation'
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
      form: 'Service/service'
    }),
    
    nameErrors () {
      const errors = []

      if (!this.$v.form.service_name.$invalid) return errors
      
      if (!this.$v.form.service_name.required) {
        errors.push('Inputan nama tidak valid')
      }

      return errors
    },

    priceErrors () {
      const errors = []

      if (!this.$v.form.price.$invalid) return errors 
      
      if (!this.$v.form.price.required) {
        errors.push('Anda belum memasukan harga jasa service')
      }

      if (!this.$v.form.price.numeric && this.$v.form.price.$dirty) {
        errors.push('Inputan harga tidak valid')
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
