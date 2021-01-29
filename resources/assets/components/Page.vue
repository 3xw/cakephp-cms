<template lang="html">
  <div class="page">

      <!-- controls -->
      <h1>Page Controls :)</h1>

      <!-- sections -->
      <slot name="sections"></slot>

      <!-- content -->
      <slot name="content"></slot>

  </div>
</template>

<script>
import Page from '../models/Page'

export default
{
  name: 'cms-page',
  props:
  {
    id: Number
  },
  computed:
  {
    page()
    {
      let pages = Page.query()
      //.with('project').with('project.account')
      .where('id', 1)
      .get()

      return pages.length? pages[0]: null
    }
  },
  created()
  {
    Page.crud().get('cms/api/pages/1')
  },
  mounted()
  {
    console.log(this.page);
  }
}
</script>
