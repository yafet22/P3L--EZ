<template>
  <VForm>
    <VLayout>
      <VFlex>
        <VTextField
          label="Nama"
          class="pa-1"
          v-model="form.customer_name"
          :error-messages="nameErrors"
          @input="$v.form.customer_name.$touch()"
          required
        />
      </VFlex>
    </VLayout>
    <VLayout>
      <VFlex>
        <VTextField
          label="Alamat"
          class="pa-1"
          v-model="form.customer_address"
          :error-messages="addressErrors"
          @input="$v.form.customer_address.$touch()"
          required
        />
      </VFlex>
    </VLayout>
    <VLayout>
      <VFlex>
        <VTextField
          label="No Telepon"
          class="pa-1"
          v-model="form.customer_phone_number"
          :error-messages="phoneNumberErrors"
          @input="$v.form.customer_phone_number.$touch()"
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
import validator from '../../validations/customerValidation'
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
      form: 'Customer/customer'
    }),
    
    nameErrors () {
      const errors = []

      if (!this.$v.form.customer_name.$invalid) return errors
      
      if (!this.$v.form.customer_name.required && this.$v.form.customer_phone_number.$dirty) {
        errors.push('Inputan nama tidak valid')
      }

      return errors
    },

    addressErrors () {
      const errors = []

      if (!this.$v.form.customer_address.$invalid) return errors 
      
      if (!this.$v.form.customer_address.required && this.$v.form.customer_phone_number.$dirty) {
        errors.push('Inputan alamat tidak valid')
      }

      return errors
    },

    phoneNumberErrors () {
      const errors = []

      if (!this.$v.form.customer_phone_number.$invalid) return errors 

      if (!this.$v.form.customer_phone_number.numeric && this.$v.form.customer_phone_number.$dirty) {
        errors.push('Inputan nomor telepon tidak valid')
      }

      if (!this.$v.form.customer_phone_number.maxLength && this.$v.form.customer_phone_number.$dirty) {
        errors.push('Nomor telepon yang anda masukkan melebihi 12 karakter')
      }

      if (!this.$v.form.customer_phone_number.required && this.$v.form.customer_phone_number.$dirty) {
        errors.push('Anda belum memasukkan nomor telepon cabang!')
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
