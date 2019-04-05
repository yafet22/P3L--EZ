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
        <VFlex sm3>
          <VTextField
            label="nomor polisi"
            class="pa-1"
            v-model="form.license_number"
            :error-messages="licenseNumberErrors"
            @input="$v.form.license_number.$touch()"
            required
          />
        </VFlex>
        <VFlex sm3>
          <v-select
            label="merk motor"
            class="pa-1"
            v-model="form.id_motorcycle_brand"
            item-text="motorcycle_brand_name"
            item-value="id_motorcycle_brand"
            :items="items"
            :return-object="false"
            :error-messages="motorcycleBrandErrors"
            @change="$.v.form.id_motorcycle_brand.$touch()"
            @input="$v.form.id_motorcycle_brand.$touch()"
            required
          ></v-select>
        </VFlex>
        <VFlex sm3>
          <v-select
            label="type motor"
            class="pa-1"
            v-model="form.id_motorcycle_type"
            item-text="motorcycle_type_name"
            item-value="id_motorcycle_type"
            :items="filtered"
            :return-object="false"
            :error-messages="motorcycleTypeErrors"
            @input="$v.form.id_motorcycle_type.$touch()"
            required
          ></v-select>
        </VFlex>
        <VFlex sm3
          class="text-xs-center"
        >
          <VBtn
            flat
            icon
            depressed
            color="success"
            @click="submitHandler"
            :disabled="!this.value"
          >
            <v-icon>check_box</v-icon>
          </VBtn>
          <VBtn
            flat
            icon
            depressed
            @click="cancelInput"
            color="error"
          >
            <v-icon>remove_circle</v-icon>
          </VBtn>
        </VFlex>
      </VLayout>
    </VForm>
   </div>
</template>

<script>
import validator from '../../validations/motorcycleValidation'
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
      items2: state => state.MotorcycleType.motorcycleTypes,
      error: state => state.Motorcycle.error,
      loading: state => state.Motorcycle.loading
      
    }),
    ...mapGetters({
      form: 'Motorcycle/motorcycle'
    }),

    filtered(){
        let filter = this.items2.filter( b => b.id_motorcycle_brand === this.form.id_motorcycle_brand)
        return filter
    },
    
    licenseNumberErrors () {
      const errors = []

      if (!this.$v.form.license_number.$invalid) return errors

      if (!this.$v.form.license_number.maxLength && this.$v.form.license_number.$dirty) {
        errors.push('Nomor Polisi Melebihi karakter yang ditentukan')
      }
      
      if (!this.$v.form.license_number.required && this.$v.form.license_number.$dirty) {
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

    motorcycleTypeErrors() {
      const errors = []

      if (!this.$v.form.id_motorcycle_type.$invalid) return errors
      
      if (!this.$v.form.id_motorcycle_type.required && this.$v.form.id_motorcycle_type.$dirty) {
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
      fetch2: 'MotorcycleType/get'
    }),
    submitHandler () {
      this.$emit('submitted', this.form)
    },
    cancelInput() {
      this.$emit('canceled')
    }
  },

  mounted () {
    this.fetch()
    this.fetch2()
  }
}
</script>
