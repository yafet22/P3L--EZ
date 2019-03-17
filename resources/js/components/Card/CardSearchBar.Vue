<template>
  <VMenu
    offset-y
    :close-on-content-click="false"
    :nudge-right="-180"
  >
    <VBtn 
      icon
      slot="activator"
    >
      <VIcon>search</VIcon>
    </VBtn>
    <VTextField 
      solo
      small
      v-model="keyword"
      hide-details
      :placeholder="placeholder"
    />
  </VMenu>
</template>

<script>
export default {
  props: {
    value: {
      type: String,
      required: true
    },

    placeholder: {
      type: String,
      default: 'Pencarian...'
    }
  },

  computed: {
    keyword: {
      get () {
        return this.value
      },

      set (val) {
        this.$emit('input', val)
      }
    }
  },

  methods: {
    clear () {
      this.$emit('input', '')
    }
  }
}
</script>
