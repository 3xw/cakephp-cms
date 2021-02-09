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
import editable from '../../mixins/editable.js'

export default
{
  name: 'cms-editable-string-input',
  mixins: ['editable'],
  props:
  {
    //originalSection: Object
  }
}
</script>
