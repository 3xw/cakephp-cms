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
import edit from '../mixins/ui/edit'

export default
{
  name: 'cms-article',
  mixins: ['edit'],
  props:
  {
    originalArticle: Object
  },
  data:() => ({
    article: null
  }),
  created()
  {
    this.article = this.originalArticle
  }
}
</script>
