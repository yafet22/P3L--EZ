<template>
  <VCard>
    <VToolbar
      card
      flat
      prominent
    >
      <VToolbarTitle v-html="title" />
      <VSpacer />
      <slot name="toolbar" />
    </VToolbar>
    <slot />
  </VCard>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      required: true
    }
  }
}
</script>

