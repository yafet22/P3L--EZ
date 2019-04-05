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
   </div>
</template>

<script>
import validator from '../../validations/serviceValidation'
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
      form: 'Service/service'
    }),

    ...mapState({
      error: state => state.Service.error,
      loading: state => state.Service.loading
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
