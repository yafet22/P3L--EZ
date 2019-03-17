import { 
    required,
    maxLength,
    numeric
  } from 'vuelidate/lib/validators'
  
  export default {
    form: {
      sales_name: { required },
      id_supplier: { required },
      sales_phone_number: {
        required,
        maxLength: maxLength(12),
        numeric
      }
    }
  }