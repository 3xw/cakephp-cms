<template lang="html">
  <div class="cms-section">

      <!-- controls -->
      <div class="controls">
        <h1>Sections Controls :)</h1>
      </div>

      <slot></slot>

  </div>
</template>

<script>
export default
{
  name: 'cms-section',
  props:
  {
    //originalSection: Object
  }
}
</script>
