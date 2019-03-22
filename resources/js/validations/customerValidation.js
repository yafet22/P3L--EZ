import { 
    required,
    maxLength,
    numeric
  } from 'vuelidate/lib/validators'
  
  export default {
    form: {
      customer_name: { required },
      customer_address: { required },
      customer_phone_number: {
        required,
        maxLength: maxLength(12),
        numeric
      }
    }
  }