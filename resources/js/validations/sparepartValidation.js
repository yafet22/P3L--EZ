import { 
    required,
    numeric
  } from 'vuelidate/lib/validators'
  
  export default {
    form: {
      id_sparepart : { required },
      sparepart_name: { required },
      merk: { required },
      id_sparepart_type: { required },
      stock: { required,numeric },
      min_stock: { required,numeric },
      purchase_price: { required,numeric },
      sell_price: { required,numeric },
      position: { required },
      place: { required },
      number: { required, numeric },
      id_motorcycle_type: {},
      id_motorcycle_brand: {}
    }
  }