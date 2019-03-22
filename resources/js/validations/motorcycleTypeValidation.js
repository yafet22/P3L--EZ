import { 
    required,
    numeric
  } from 'vuelidate/lib/validators'
  
  export default {
    form: {
      motorcycle_type_name: { required },
      id_motorcycle_brand: {required}
    }
  }