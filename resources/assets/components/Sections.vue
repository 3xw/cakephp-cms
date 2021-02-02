<template lang="html">

  <draggable v-model="sections">
    <slot />
  </draggable>

</template>

<script>
export default
{
  name: 'cms-sections',
  props:
  {
    originalSections: Array
  },
  data()
  {
    return {
      sections: []
    }
  },
  created()
  {
    this.sections = this.originalSections
  }
}
</script>
