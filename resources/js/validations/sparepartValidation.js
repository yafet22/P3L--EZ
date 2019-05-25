import { 
    required,
    numeric
  } from 'vuelidate/lib/validators'

  function priceMinimal(){
    if(Number(this.form.sell_price)<Number(this.form.purchase_price))
    {
        return false
    }
    return true
  }

  function stockMinimal(){
    if(Number(this.form.stock)<Number(this.form.min_stock))
    {
        return false
    }
    return true
  }
  
  export default {
    form: {
      id_sparepart : { required,
          
      },
      sparepart_name: { required },
      merk: { required },
      id_sparepart_type: { required },
      stock: { required,numeric,stockMinimal },
      min_stock: { required,numeric },
      purchase_price: { required,numeric },
      sell_price: { required,numeric,priceMinimal },
      position: { required },
      place: { required },
      number: { required, numeric },
      id_motorcycle_type: {},
      id_motorcycle_brand: {}
    }
  }