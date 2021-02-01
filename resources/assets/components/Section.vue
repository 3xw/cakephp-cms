<template lang="html">
  <div class="section">

      <!-- controls -->
      <h1>Sections Controls :)</h1>

      <!-- sections -->
      <slot name="items"></slot>

      <!-- content -->
      <slot name="content"></slot>

  </div>
</template>

<script>
//import Page from '../models/Page'

export default
{
  name: 'cms-section',
  props:
  {
    id: Number
  }
}
</script>
