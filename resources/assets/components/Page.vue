<template lang="html">
  <div class="cms-page">

    <!-- controls -->
    <div class="cms-controls">
      <el-button-group>
        <el-button size="mini" type="primary" >Editer</el-button>
        <el-button size="mini" type="danger">Effacer</el-button>
        <el-button size="mini" type="success" @click="section.drawer = true">Ajouter une section</el-button>
      </el-button-group>
    </div>

    <!-- section modal -->
    <el-dialog title="Nouvelle section" :visible.sync="section.drawer" width="60%" >
      <el-select v-model="section.item.template" placeholder="Choisir un type de section" :default-first-option="true">
        <el-option v-for="(section, name) in settings.Sections" :key="name" :label="name" :value="section.template"></el-option>
      </el-select><br/>
      <el-button type="primary" @click="createSection(); section.drawer = false">Créer la section</el-button>
    </el-dialog>

    <div class="cms-content">
      <slot></slot>
    </div>

  </div>
</template>

<script>
import Page from '../models/Page'
import Section from '../models/Section'

export default
{
  name: 'cms-page',
  props:
  {
    pageId: String,
    settings: Object
  },
  data()
  {
    return {
      section: {
        drawer: false,
        item: {
          template: null
        }
      }
    }
  },
  computed:
  {
    page()
    {
      return Page.query().with('sections.section_items.article').where(this.pageId).first()
    }
  },
  created()
  {
    // load page content!!
    Page.crud().getOne(this.pageId)
  },
  methods:
  {
    createSection()
    {
      let section = new Section(this.section.item)
      section.order = this.page.sections.length
      section
      .save(null, null, {relations:[this.page]})
      .then(data => window.location.reload())
      .catch(error => console.log(error))
    }
  }
}
</script>
