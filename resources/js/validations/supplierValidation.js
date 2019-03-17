import { 
    required,
    maxLength,
    numeric
  } from 'vuelidate/lib/validators'
  
  export default {
    form: {
      supplier_name: { required },
      supplier_address: { required },
      supplier_phone_number: {
        required,
        maxLength: maxLength(12),
        numeric
      }
    }
  }