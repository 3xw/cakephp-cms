<template lang="html">
  <div class="page">

      <!-- controls -->
      <div class="container">
        <section class="cms-page-controls">
          Page controls here<br>
          <button type="button" name="button" @click="sectionDrawer = true">Add new section</button>
        </section>
      </div>

      <!-- section modal -->
      <el-drawer title="Ajouter une section à la page" :visible.sync="sectionDrawer" direction="ltr" >
        <p>
          Choissiez le type de section que vous souhaitez ajouter à a page courante.
        </p>
        <p>
          
        </p>
      </el-drawer>

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
    originalPage: Object,
    settings: Object
  },
  data()
  {
    return {
      sectionDrawer: false
    }
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
  mounted() {},
  methods: {}
}
</script>
