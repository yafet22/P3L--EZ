import { 
    required,
    maxLength,
    numeric
  } from 'vuelidate/lib/validators'
  
  export default {
    form: {
      license_number: { maxLength: maxLength(11),required },
      id_motorcycle_brand: { required },
      id_motorcycle_type: { required }
    }
  }