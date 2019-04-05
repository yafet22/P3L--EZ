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
            label="Nama Depan"
            class="pa-1"
            v-model="form.first_name"
            :error-messages="nameErrors"
            @input="$v.form.first_name.$touch()"
            required
          />
        </VFlex>
      </VLayout>
      <VLayout>
        <VFlex>
          <VTextField
            label="Nama Belakang"
            class="pa-1"
            v-model="form.last_name"
            @input="$v.form.last_name.$touch()"
            required
          />
        </VFlex>
      </VLayout>
      <VLayout>
        <VFlex>
          <VTextField
            label="Alamat"
            class="pa-1"
            v-model="form.address"
            :error-messages="addressErrors"
            @input="$v.form.address.$touch()"
            required
          />
        </VFlex>
      </VLayout>
      <VLayout>
        <VFlex>
          <VTextField
            label="No Telepon"
            class="pa-1"
            v-model="form.phone_number"
            :error-messages="phoneNumberErrors"
            @input="$v.form.phone_number.$touch()"
            required
          />
        </VFlex>
      </VLayout>
      <VLayout>
        <VFlex>
          <VTextField
            label="Gaji"
            class="pa-1"
            v-model="form.salary"
            :error-messages="salaryErrors"
            @input="$v.form.salary.$touch()"
            required
          />
        </VFlex>
      </VLayout>
      <VLayout>
        <VFlex>
          <v-select
            label="Jabatan"
            class="pa-1"
            v-model="form.id_role"
            item-text="role_name"
            item-value="id_role"
            :items="items"
            :return-object="false"
            :error-messages="roleErrors"
            @input="$v.form.id_role.$touch()"
            required
          ></v-select>
        </VFlex>
      </VLayout>
      <VLayout>
        <VFlex>
          <v-select
            label="Cabang"
            class="pa-1"
            v-model="form.id_branch"
            item-text="branch_name"
            item-value="id_branch"
            :items="items2"
            :return-object="false"
            :error-messages="branchErrors"
            @input="$v.form.id_branch.$touch()"
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
import validator from '../../validations/employeeValidation'
import { mapGetters,mapState, mapActions } from 'vuex'
import roleService from '../../service/Role'
import branchService from '../../service/Branch'

export default {
  props: {
    value: {
      type: Boolean,
      default: false
    }
  },

  computed: {
    ...mapState({
      items: state => state.Role.roles,
      items2: state => state.Branch.branches,
      error: state => state.Employee.error,
      loading: state => state.Employee.loading    
    }),

    ...mapGetters({
      form: 'Employee/employee',
    }),
    
    nameErrors () {
      const errors = []

      if (!this.$v.form.first_name.$invalid) return errors
      
      if (!this.$v.form.first_name.required && this.$v.form.phone_number.$dirty) {
        errors.push('Inputan nama tidak valid')
      }

      return errors
    },

    addressErrors () {
      const errors = []

      if (!this.$v.form.address.$invalid) return errors 
      
      if (!this.$v.form.address.required && this.$v.form.phone_number.$dirty) {
        errors.push('Inputan alamat tidak valid')
      }

      return errors
    },

    phoneNumberErrors () {
      const errors = []

      if (!this.$v.form.phone_number.$invalid) return errors 

      if (!this.$v.form.phone_number.numeric && this.$v.form.phone_number.$dirty) {
        errors.push('Inputan nomor telepon tidak valid')
      }

      if (!this.$v.form.phone_number.maxLength && this.$v.form.phone_number.$dirty) {
        errors.push('Nomor telepon yang anda masukkan melebihi 12 karakter')
      }

      if (!this.$v.form.phone_number.required && this.$v.form.phone_number.$dirty) {
        errors.push('Anda belum memasukkan nomor telepon !')
      }

      return errors
    },

    salaryErrors () {
      const errors = []

      if (!this.$v.form.salary.$invalid) return errors 

      if (!this.$v.form.salary.numeric && this.$v.form.salary.$dirty) {
        errors.push('Inputan gaji tidak valid')
      }

      if (!this.$v.form.salary.required && this.$v.form.salary.$dirty) {
        errors.push('Anda belum memasukkan gaji karyawan!')
      }

      return errors
    },

    userErrors () {
      const errors = []

      if (!this.$v.form.id_user.$invalid) return errors 
      
      if (!this.$v.form.id_user.required && this.$v.form.id_user.$dirty) {
        errors.push('Inputan user tidak valid')
      }

      return errors
    },

    branchErrors () {
      const errors = []

      if (!this.$v.form.id_branch.$invalid) return errors 
      
      if (!this.$v.form.id_branch.required && this.$v.form.id_branch.$dirty) {
        errors.push('Inputan cabang tidak valid')
      }

      return errors
    },

    roleErrors () {
      const errors = []

      if (!this.$v.form.id_role.$invalid) return errors 
      
      if (!this.$v.form.id_role.required && this.$v.form.id_role.$dirty) {
        errors.push('Inputan jabatan tidak valid')
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
      fetch: 'Role/get',
      fetch2: 'Branch/get'
    }),
    submitHandler () {
      console.log(this.form.first_name)
      this.$emit('submitted', this.form)
    }
  },

  mounted () {
    this.fetch()
    this.fetch2()
  }
}
</script>
