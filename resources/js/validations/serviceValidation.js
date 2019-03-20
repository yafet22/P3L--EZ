import { 
    required,
    numeric
  } from 'vuelidate/lib/validators'
  
  export default {
    form: {
      service_name: { required },
      price: {
        required,
        numeric
      }
    }
  }