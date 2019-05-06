import { 
    required,
    numeric
  } from 'vuelidate/lib/validators'
  
  export default {
    form: {
      discount: { numeric },
      payamount: { numeric,required }
    }
  }