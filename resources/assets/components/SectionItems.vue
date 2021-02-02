<template lang="html">

  <draggable v-model="sectionItems">
    <slot />
  </draggable>

</template>

<script>
export default
{
  name: 'cms-section-items',
  props:
  {
    originalSectionItems: Array
  },
  data()
  {
    return {
      sections: []
    }
  },
  created()
  {
    this.sectionItems = this.originalSectionItems
  }
}
</script>
