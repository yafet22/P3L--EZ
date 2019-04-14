import sparepartService from '../../service/Sparepart'

const state = {
  spareparts: [],
  sparepart: { 
    id_sparepart: '',
    sparepart_name: '',
    merk: '',
    stock: '',
    min_stock: '',
    purchase_price: '',
    sell_price: '',
    placement: '',
    position: '',
    place: '',
    number: '',
    image: '',
    id_sparepart_type: '',
    id_motorcycle_type: '',
    id_motorcycle_brand: '',
    motorcycleTypes: [],
    compatibility: [],
  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.spareparts = payload
    state.loading = false
    state.error = null
  },

  setFailedAction(state, payload) {
    state.loading = false
    state.error = payload.error
  },

  resetSparepartForm(state) {
    state.sparepart.id_sparepart = ""
    state.sparepart.sparepart_name = ""
    state.sparepart.merk =  state.sparepart.stock = ""
    state.sparepart.purchase_price = ""
    state.sparepart.sell_price = ""
    state.sparepart.placement = ""
    state.sparepart.position = ""
    state.sparepart.place = ""
    state.sparepart.compatibility = []
  },

  setSparepartForm(state, payload) {
    state.sparepart.id_sparepart = payload.id_sparepart
    state.sparepart.sparepart_name = payload.sparepart_name
    state.sparepart.merk = payload.merk
    state.sparepart.stock = payload.stock
    state.sparepart.min_stock = payload.min_stock
    state.sparepart.purchase_price = payload.purchase_price
    state.sparepart.sell_price = payload.sell_price
    state.sparepart.placement = payload.placement
    state.sparepart.position = payload.position
    state.sparepart.place = payload.place
    state.sparepart.number = payload.number
    state.sparepart.image = payload.image
    state.sparepart.id_sparepart_type = payload.id_sparepart_type
    state.sparepart.compatibility = payload.compatibility.data
    var finalArray = payload.compatibility.data.map(function (obj) {
      return obj.id_motorcycle_type;
    });
    state.sparepart.motorcycleTypes = finalArray
  }
}

const getters = {
  error: state => state.error,
  loading: state => state.loading,
  sparepart: state => state.sparepart
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await sparepartService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await sparepartService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      const res = await sparepartService.find(id)
      context.commit('setSparepartForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {

      let data = new FormData();
      data.append('sparepart_name',payload.sparepart_name)
      data.append('image',payload.image)
      data.append('merk',payload.merk)
      data.append('id_sparepart',payload.id_sparepart)
      data.append('stock',payload.stock)
      data.append('min_stock',payload.min_stock)
      data.append('purchase_price',payload.purchase_price)
      data.append('sell_price',payload.sell_price)
      data.append('placement',payload.placement)
      data.append('id_sparepart_type',payload.id_sparepart_type)
      data.append('motorcycleTypes',payload.motorcycleTypes)

      await sparepartService.update(payload.id_sparepart, data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async verification(context, payload) {
    try {
      const data = {
        spareparts: payload.spareparts,
      }
      await sparepartService.verification(data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await sparepartService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('resetSparepartForm')
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}