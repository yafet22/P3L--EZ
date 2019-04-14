import { 
    required,
    maxLength,
    numeric
  } from 'vuelidate/lib/validators'
  
  export default {
    form: {
      date: { required },
      id_sales: { required },
      id_supplier: { required },
      procurement_status: { required }
    }
  }