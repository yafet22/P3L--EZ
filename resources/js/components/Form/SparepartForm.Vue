<template>
  <VForm>
    <VLayout>
      <VFlex class="text-xs-center">
        <img :src="imageUrl" height="150" v-if="imageUrl"/>
        <img :src="'/images/'+form.image" height="150" :alt="form.image" v-else-if="form.image"/>
        <img :src="defaultImg" height="150" v-else/>
        <v-text-field label="Pilih Gambar" class="pa-1" @click='pickFile' v-model='imageName' @input="$v.form.image.$touch()"/>
        <input
          type="file"
          style="display: none"
          ref="image"
          accept="image/*"
          @change="onFilePicked"
        >
      </VFlex>
    </VLayout>
    <VLayout>
      <VFlex>
        <VTextField
          label="Id Sparepart"
          class="pa-1"
          v-model="form.id_sparepart"
          :error-messages="idErrors"
          @input="$v.form.id_sparepart.$touch()"
          required
        />
      </VFlex>
    </VLayout>
    <VLayout>
      <VFlex>
        <VTextField
          label="Nama"
          class="pa-1"
          v-model="form.sparepart_name"
          :error-messages="nameErrors"
          @input="$v.form.sparepart_name.$touch()"
          required
        />
      </VFlex>
    </VLayout>
    <VLayout>
      <VFlex>
        <VTextField
          label="Merk"
          class="pa-1"
          v-model="form.merk"
          :error-messages="merkErrors"
          @input="$v.form.merk.$touch()"
          required
        />
      </VFlex>
    </VLayout>
    <VLayout>
      <VFlex>
        <v-select
          label="Sparepart type"
          class="pa-1"
          v-model="form.id_sparepart_type"
          item-text="sparepart_type_name"
          item-value="id_sparepart_type"
          :items="items"
          :return-object="false"
          :error-messages="sparepartTypeErrors"
          @input="$v.form.id_sparepart_type.$touch()"
          required
        ></v-select>
      </VFlex>
    </VLayout>
    <VLayout>
      <VFlex>
        <VTextField
          label="Stock"
          class="pa-1"
          v-model="form.stock"
          :error-messages="stockErrors"
          @input="$v.form.stock.$touch()"
          required
        />
      </VFlex>
    </VLayout>
    <VLayout>
      <VFlex>
        <VTextField
          label="Min Stock"
          class="pa-1"
          v-model="form.min_stock"
          :error-messages="minStockErrors"
          @input="$v.form.min_stock.$touch()"
          required
        />
      </VFlex>
    </VLayout>
    <VLayout>
      <VFlex>
        <VTextField
          label="Harga Beli"
          class="pa-1"
          v-model="form.purchase_price"
          :error-messages="purchasePriceErrors"
          @input="$v.form.purchase_price.$touch()"
          required
        />
      </VFlex>
    </VLayout>
    <VLayout>
      <VFlex>
        <VTextField
          label="Harga Jual"
          class="pa-1"
          v-model="form.sell_price"
          :error-messages="sellPriceErrors"
          @input="$v.form.sell_price.$touch()"
          required
        />
      </VFlex>
    </VLayout>
    <VLayout>
      <VFlex sm6>
        <v-select
          label="Posisi"
          class="pa-1"
          v-model="form.position"
          item-text="text"
          item-value="id"
          :items="positions"
          :return-object="false"
          :error-messages="positionErrors"
          @input="$v.form.position.$touch()"
          required
        ></v-select>
      </VFlex>
      <VFlex sm6>
        <v-select
          label="Tempat"
          class="pa-1"
          v-model="form.place"
          item-text="text"
          item-value="id"
          :items="places"
          :return-object="false"
          :error-messages="placeErrors"
          @input="$v.form.place.$touch()"
          required
        ></v-select>
      </VFlex>
      <VFlex sm6>
          <VTextField
          label="Nomor Urut"
          class="pa-1"
          v-model="form.number"
          :error-messages="numberErrors"
          @input="$v.form.number.$touch()"
          required
        />
      </VFlex>
    </VLayout>
    <VSpacer />
    <VLayout>
      <VFlex
        class="text-xs-center"
      >
        <VBtn
          depressed
          color="success"
          @click="submitHandler"
          :disabled="!this.value"
        >
          Kirim
        </VBtn>
      </VFlex>
    </VLayout>
  </VForm>
</template>

<script>
import validator from '../../validations/sparepartValidation'
import sparepartTypeService from '../../service/SparepartType'
import { mapGetters,mapState, mapActions } from 'vuex'

export default {
  props: {
    value: {
      type: Boolean,
      default: false,
    }
  },
  data () {
    return {
      positions: [
        { id: "DPN", text: 'Depan' },
        { id: "TGH", text: 'Tengah' },
        { id: "BLK", text: 'Belakang' }
      ],
      places: [
        { id: "KACA", text: 'Rak Kaca' },
        { id: "DUS", text: 'Tumpukan Dus' },
        { id: "KAYU", text: 'Lemari Kayu' }
      ],
      imageName: '',
      defaultImg: 'http://localhost:8000/asset/default.png',
      imageUrl: '',
    }
  },
  computed: {

    ...mapState({
      items: state => state.SparepartType.sparepartTypes,
    }),

    ...mapGetters({
      form: 'Sparepart/sparepart'
    }),
    
    nameErrors () {
      const errors = []

      if (!this.$v.form.sparepart_name.$invalid) return errors
      
      if (!this.$v.form.sparepart_name.required && this.$v.form.sparepart_name.$dirty) {
        errors.push('Inputan nama tidak valid')
      }

      return errors
    },

    sparepartTypeErrors () {
      const errors = []

      if (!this.$v.form.id_sparepart_type.$invalid) return errors
      
      if (!this.$v.form.id_sparepart_type.required && this.$v.form.id_sparepart_type.$dirty) {
        errors.push('Inputan nama tidak valid')
      }

      return errors
    },

    idErrors () {
      const errors = []

      if (!this.$v.form.id_sparepart.$invalid) return errors 
      
      if (!this.$v.form.id_sparepart.required && this.$v.form.id_sparepart.$dirty) {
        errors.push('Inputan id tidak valid')
      }

      return errors
    },

    merkErrors () {
      const errors = []

      if (!this.$v.form.merk.$invalid) return errors 
      
      if (!this.$v.form.merk.required && this.$v.form.merk.$dirty) {
        errors.push('Inputan merk tidak valid')
      }

      return errors
    },

    idSparepartTypeErrors () {
      const errors = []

      if (!this.$v.form.id_sparepart_type.$invalid) return errors 
      
      if (!this.$v.form.id_sparepart_type.required && this.$v.form.id_sparepart_type.$dirty) {
        errors.push('Inputan id_sparepart_type tidak valid')
      }

      return errors
    },


    stockErrors () {
      const errors = []

      if (!this.$v.form.stock.$invalid) return errors 
      
      if (!this.$v.form.stock.required && this.$v.form.stock.$dirty) {
        errors.push('Inputan stock tidak valid')
      }

      if (!this.$v.form.stock.numeric && this.$v.form.stock.$dirty) {
        errors.push('Inputan stock tidak valid')
      }

      return errors
    },

    minStockErrors () {
      const errors = []

      if (!this.$v.form.min_stock.$invalid) return errors 
      
      if (!this.$v.form.min_stock.required && this.$v.form.min_stock.$dirty) {
        errors.push('Inputan minimal stock tidak valid')
      }

      if (!this.$v.form.min_stock.numeric && this.$v.form.min_stock.$dirty) {
        errors.push('Inputan minimal stock tidak valid')
      }

      return errors
    },

    purchasePriceErrors () {
      const errors = []

      if (!this.$v.form.purchase_price.$invalid) return errors 
      
      if (!this.$v.form.purchase_price.required && this.$v.form.purchase_price.$dirty) {
        errors.push('Inputan harga beli tidak valid')
      }

      if (!this.$v.form.purchase_price.numeric && this.$v.form.purchase_price.$dirty) {
        errors.push('Inputan harga beli tidak valid')
      }

      return errors
    },

    sellPriceErrors () {
      const errors = []

      if (!this.$v.form.sell_price.$invalid) return errors 
      
      if (!this.$v.form.sell_price.required && this.$v.form.sell_price.$dirty) {
        errors.push('Inputan harga jual tidak valid')
      }

      if (!this.$v.form.sell_price.numeric && this.$v.form.sell_price.$dirty) {
        errors.push('Inputan harga jual tidak valid')
      }

      return errors
    },

    numberErrors () {
      const errors = []

      if (!this.$v.form.number.$invalid) return errors 
      
      if (!this.$v.form.number.required && this.$v.form.number.$dirty) {
        errors.push('Inputan harga jual tidak valid')
      }

      if (!this.$v.form.number.numeric && this.$v.form.number.$dirty) {
        errors.push('Inputan harga jual tidak valid')
      }

      return errors
    },

    positionErrors () {
      const errors = []

      if (!this.$v.form.position.$invalid) return errors 
      
      if (!this.$v.form.position.required && this.$v.form.position.$dirty) {
        errors.push('Inputan posisi tidak valid')
      }

      return errors
    },

    placeErrors () {
      const errors = []

      if (!this.$v.form.place.$invalid) return errors 
      
      if (!this.$v.form.place.required && this.$v.form.place.$dirty) {
        errors.push('Inputan place tidak valid')
      }

      return errors
    },
  },

  validations: validator,

  watch: {
    form: {
      deep: true,
      handler () {
        this.$emit('input', !this.$v.form.$invalid)
      }
    }    
  },

  methods: {
    ...mapActions({
      fetch: 'SparepartType/get',
    }),
    submitHandler () {
      this.$emit('submitted', this.form)
    },
    pickFile () {
            this.$refs.image.click ()
        },
		
		onFilePicked (e) {
			const files = e.target.files
			if(files[0] !== undefined) {
				this.imageName = files[0].name
				if(this.imageName.lastIndexOf('.') <= 0) {
					return
				}
				const fr = new FileReader ()
				fr.readAsDataURL(files[0])
				fr.addEventListener('load', () => {
					this.imageUrl = fr.result
					this.form.image = files[0] // this is an image file that can be sent to server...
				})
			} else {
				this.imageName = ''
				this.imageUrl = 'http://localhost:8000/asset/default.png'
			}
		}
  },

  mounted () {
    this.fetch()
  }
}
</script>
