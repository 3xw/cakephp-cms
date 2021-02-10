<template lang="html">
  <div v-if="edit" class="cms-section-item">
    <el-select v-if="templates" v-model="field" placeholder="Choisir un type de template" >
      <el-option v-for="(templ, index) in templates" :key="index" :label="templ.name" :value="templ.template"></el-option>
    </el-select>
  </div>
</template>

<script>
import mutableInput from '../mixins/ui/mutableInput.js'
import editable from '../mixins/editable'

export default
{
  name: 'cms-section-item',
  mixins: [mutableInput, editable],
  props:
  {
    settings:Object
  },
  computed:
  {
    sectionTemplate()
    {
      let section = this.$store.$db().model('sections')
      .query()
      .whereId(this.entity.section_id)
      .first()
      if(!section) return null
      return section.template
    },
    templates()
    {
      let templates = [{label: 'default', value: 'Trois/Cms.articles/default'}]
      if(!this.sectionTemplate) return templates

      let allowed = this.settings.Tree.sections.map(s =>{
        if(s.template == this.sectionTemplate) return s.articles
      })
      if(!allowed.length) return templates

      // flatten array
      allowed = [].concat.apply([], allowed)
      return this.settings.Tree.articles.map(a => {
        if(allowed.indexOf(a.name) != -1) return a
      })
    }
  }
}
</script>
