<template>
  <div>
    <VCardText
      v-if="loading || error"
      class="text-xs-center"
    >
      <VAlert
        v-if="error"
        :value="true"
        dismissible
        type="error"
      >
      {{ error.message }}
      </VAlert>
      <VProgressCircular
        v-if="loading"
        :size="45"
        indeterminate
        class="loading-section"
      />
    </VCardText>
    <VForm>
      <VLayout>
        <VFlex>
          <VTextField
            label="Nama"
            class="pa-1"
            v-model="form.supplier_name"
            :error-messages="nameErrors"
            @input="$v.form.supplier_name.$touch()"
            @blur="$v.form.supplier_name.$touch()"
            required
          />
        </VFlex>
      </VLayout>
      <VLayout>
        <VFlex>
          <VTextField
            label="Alamat"
            class="pa-1"
            v-model="form.supplier_address"
            :error-messages="addressErrors"
            @input="$v.form.supplier_address.$touch()"
            @blur="$v.form.supplier_address.$touch()"
            required
          />
        </VFlex>
      </VLayout>
      <VLayout>
        <VFlex>
          <VTextField
            label="No Telepon"
            class="pa-1"
            v-model="form.supplier_phone_number"
            :error-messages="phoneNumberErrors"
            @input="$v.form.supplier_phone_number.$touch()"
            @blur="$v.form.supplier_phone_number.$touch()"
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
   </div>
</template>

<script>
import validator from '../../validations/supplierValidation'
import { mapGetters, mapState } from 'vuex'

export default {
  props: {
    value: {
      type: Boolean,
      default: false
    }
  },

  computed: {
    ...mapGetters({
      form: 'Supplier/supplier'
    }),

    ...mapState({
      error: state => state.Supplier.error,
      loading: state => state.Supplier.loading
    }),
    
    nameErrors () {
      const errors = []

      if (!this.$v.form.supplier_name.$invalid) return errors
      
      if (!this.$v.form.supplier_name.required && this.$v.form.supplier_name.$dirty) {
        errors.push('Inputan nama tidak valid')
      }

      return errors
    },

    addressErrors () {
      const errors = []

      if (!this.$v.form.supplier_address.$invalid) return errors 
      
      if (!this.$v.form.supplier_address.required && this.$v.form.supplier_address.$dirty) {
        errors.push('Inputan alamat tidak valid')
      }

      return errors
    },

    phoneNumberErrors () {
      const errors = []

      if (!this.$v.form.supplier_phone_number.$invalid) return errors 

      if (!this.$v.form.supplier_phone_number.numeric && this.$v.form.supplier_phone_number.$dirty) {
        errors.push('Inputan nomor telepon tidak valid')
      }

      if (!this.$v.form.supplier_phone_number.maxLength && this.$v.form.supplier_phone_number.$dirty) {
        errors.push('Nomor telepon yang anda masukkan melebihi 12 karakter')
      }

      if (!this.$v.form.supplier_phone_number.required && this.$v.form.supplier_phone_number.$dirty) {
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
