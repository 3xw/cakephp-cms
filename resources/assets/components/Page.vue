<template lang="html">
  <div class="page">
      <!-- controls -->
      <h1>Page Controls :)</h1>

      <!-- sections -->
      <slot></slot>
  </div>
</template>

<script>
import Page from '../models/Page'

export default
{
  name: 'cms-page',
  created()
  {
    console.log(Page);
    console.log(Page.prototype.sayHello());
    console.log(Page.prototype.save());
  },
}
</script>
