<template lang="html">
  <div class="cms-page">

    <!-- controls -->
    <div class="controls">
      Page controls here<br>
      <button type="button" name="button" @click="section.drawer = true">Ajouter une section</button>
    </div>

    <!-- section modal -->
    <el-dialog title="Nouvelle section" :visible.sync="section.drawer" width="60%" >
      <el-select v-model="section.item.template" placeholder="Choisir un type de section" :default-first-option="true">
        <el-option v-for="(section, name) in settings.Sections" :key="name" :label="name" :value="section.template"></el-option>
      </el-select><br/>
      <el-button type="primary" @click="createSection(); section.drawer = false">Créer la section</el-button>
    </el-dialog>

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
    originalPage: Object,
    settings: Object
  },
  data()
  {
    return {
      section: {
        drawer: false,
        item: {template: null}
      }
    }
  },
  created()
  {
    // load page content!!
    Page.crud().get('cms/api/pages/'+this.originalPage.id)
  },
  methods:
  {
    createSection()
    {
      let section = new Section(this.section.item)
      .save('cms/api/pages/'+this.originalPage.id+'/sections')
      .then(data => window.location.reload())
      .catch(error => console.log(error))
    }
  }
}
</script>
