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
            v-model="form.sales_name"
            :error-messages="nameErrors"
            @input="$v.form.sales_name.$touch()"
            required
          />
        </VFlex>
      </VLayout>
      <VLayout>
        <VFlex>
          <VTextField
            label="No Telepon"
            class="pa-1"
            v-model="form.sales_phone_number"
            :error-messages="phoneNumberErrors"
            @input="$v.form.sales_phone_number.$touch()"
            required
          />
        </VFlex>
      </VLayout>
      <VLayout>
        <VFlex>
          <v-select
            label="Supplier"
            class="pa-1"
            v-model="form.id_supplier"
            item-text="supplier_name"
            item-value="id_supplier"
            :items="items"
            :return-object="false"
            :error-messages="supplierErrors"
            @input="$v.form.id_supplier.$touch()"
            required
          ></v-select>
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
import validator from '../../validations/salesValidation'
import supplierService from '../../service/Supplier'
import { mapGetters,mapState, mapActions } from 'vuex'

export default {
  props: {
    value: {
      type: Boolean,
      default: false
    }
  },

  computed: {
    ...mapState({
      items: state => state.Supplier.suppliers,  
      error: state => state.Sales.error,
      loading: state => state.Sales.loading
    }),

    ...mapGetters({
      form: 'Sales/sales'
    }),
    
    nameErrors () {
      const errors = []

      if (!this.$v.form.sales_name.$invalid) return errors
      
      if (!this.$v.form.sales_name.required && this.$v.form.sales_phone_number.$dirty) {
        errors.push('Inputan nama tidak valid')
      }

      return errors
    },

    phoneNumberErrors () {
      const errors = []

      if (!this.$v.form.sales_phone_number.$invalid) return errors 

      if (!this.$v.form.sales_phone_number.numeric && this.$v.form.sales_phone_number.$dirty) {
        errors.push('Inputan nomor telepon tidak valid')
      }

      if (!this.$v.form.sales_phone_number.maxLength && this.$v.form.sales_phone_number.$dirty) {
        errors.push('Nomor telepon yang anda masukkan melebihi 12 karakter')
      }

      if (!this.$v.form.sales_phone_number.required && this.$v.form.sales_phone_number.$dirty) {
        errors.push('Anda belum memasukkan nomor telepon cabang!')
      }

      return errors
    },

    supplierErrors () {
      const errors = []

      if (!this.$v.form.id_supplier.$invalid) return errors 
      
      if (!this.$v.form.id_supplier.required && this.$v.form.sales_phone_number.$dirty) {
        errors.push('Inputan supplier tidak valid')
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
    ...mapActions({
      fetch: 'Supplier/get',
    }),
    submitHandler () {
      this.$emit('submitted', this.form)
    }
  },

  mounted () {
    this.fetch()
  }
}
</script>
