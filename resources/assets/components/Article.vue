<template lang="html">
  <div class="cms-article">

      <!-- controls -->
      <div class="control">
        <h1>Article Controls :)</h1>
      </div>

      <slot></slot>
      
  </div>
</template>

<script>
export default
{
  name: 'cms-article',
  props:
  {
    //originalArtcile: Object
  }
}
</script>
