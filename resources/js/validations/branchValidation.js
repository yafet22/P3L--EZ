import { 
    required,
    maxLength,
    numeric
  } from 'vuelidate/lib/validators'
  
  export default {
    form: {
      branch_name: { required },
      branch_address: { required },
      branch_phone_number: {
        required,
        maxLength: maxLength(12),
        numeric
      }
    }
  }