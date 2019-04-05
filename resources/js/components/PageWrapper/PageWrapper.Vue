<template>
  <VContainer>
    <VLayout
      row
      wrap
      justify-center
    >
      <VFlex
        :lg12="!narrow"
        :lg10="narrow"
      >
        <VBreadcrumbs
          :items="breadcrumbs"
          divider=">"
          class="pt-0"
        >
        </VBreadcrumbs>
      </VFlex>
      <VFlex
        :lg12="!narrow"
        :lg10="narrow"
        md12
        xs12
      >
        <VSlideYTransition>
          <slot v-if="!loading" />
        </VSlideYTransition>
      </VFlex>
    </VLayout>
  </VContainer>
</template>

<script>
export default {
  props: {
    narrow: {
      type: Boolean,
      default: false
    },
    breadcrumbs: {
      type: Array,
      default: () => []
    },
    loading: {
      type: Boolean,
      default: false
    }
  },
}
</script>
