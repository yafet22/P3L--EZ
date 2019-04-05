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
   </div>
</template>

<script>
import validator from '../../validations/motorcycleBrandValidation'
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
      form: 'MotorcycleBrand/motorcycleBrand'
    }),

    ...mapState({
      error: state => state.MotorcycleBrand.error,
      loading: state => state.MotorcycleBrand.loading
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
