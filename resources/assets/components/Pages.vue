<template>
  <div>
    <h2>Pages index</h2>
    <ul>
      <li v-for="page in entities">
        {{page.title}}
      </li>
    </ul>
  </div>
</template>
<script>
import draggable from 'vuedraggable'
import editable from '../mixins/editable'
import settings from '../mixins/settings'
import Page from '../models/Page'

export default {
  name: 'cms-pages',
  mixins: [editable, settings],
  data: () => ({
  }),
  computed: {
    Page() { return this.$store.$db().model('pages') },
    entities() { return this.Page.query().orderBy('lft').get() },
  },
  created(){ this.Page.crud().get() },
  watch: {
    pagesItems: function(){
      console.log(this.entities);
    }
  }
}
</script>
