import { 
    required,
    maxLength,
    numeric
  } from 'vuelidate/lib/validators'
  
  export default {
    form: {
      password: { required }
    }
  }