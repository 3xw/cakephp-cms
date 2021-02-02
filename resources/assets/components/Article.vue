<template lang="html">
  <div class="cms-article">

      <!-- controls -->
      <h1>Article Controls :)</h1>

      <!-- content -->
      <slot name="content"></slot>

  </div>
</template>

<script>
export default
{
  name: 'cms-article',
  props:
  {
    originalArtcile: Object
  }
}
</script>
