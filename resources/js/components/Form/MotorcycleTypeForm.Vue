<template>
  <VForm>
    <VLayout>
      <VFlex>
        <VTextField
          label="Nama"
          class="pa-1"
          v-model="form.motorcycle_type_name"
          :error-messages="nameErrors"
          @input="$v.form.motorcycle_type_name.$touch()"
          required
        />
      </VFlex>
    </VLayout>
    <VLayout>
      <VFlex>
        <v-select
          label="Brand"
          class="pa-1"
          v-model="form.id_motorcycle_brand"
          item-text="motorcycle_brand_name"
          item-value="id_motorcycle_brand"
          :items="items"
          :return-object="false"
          :error-messages="motorcycleBrandErrors"
          @input="$v.form.id_motorcycle_brand.$touch()"
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
</template>

<script>
import validator from '../../validations/motorcycleTypeValidation'
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
      items: state => state.MotorcycleBrand.motorcycleBrands,
      
    }),
    ...mapGetters({
      form: 'MotorcycleType/motorcycleType'
    }),
    
    nameErrors () {
      const errors = []

      if (!this.$v.form.motorcycle_type_name.$invalid) return errors
      
      if (!this.$v.form.motorcycle_type_name.required && this.$v.form.motorcycle_type_name.$dirty) {
        errors.push('Inputan nama tidak valid')
      }

      return errors
    },

    motorcycleBrandErrors() {
      const errors = []

      if (!this.$v.form.id_motorcycle_brand.$invalid) return errors
      
      if (!this.$v.form.id_motorcycle_brand.required && this.$v.form.id_motorcycle_brand.$dirty) {
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
    ...mapActions({
      fetch: 'MotorcycleBrand/get',
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
