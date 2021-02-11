<template lang="html">
  <div class="cms-page">

    <!-- controls -->
    <div class="cms-controls">
      <el-button-group>
        <el-button v-if="!edit" @click="edit = true" size="mini" type="primary" >Editer</el-button>
        <el-button v-if="!edit" @click="crudDelete()" size="mini" type="danger">Effacer</el-button>
        <el-button v-if="!edit" @click="add = true" size="mini" type="success">Ajouter une section</el-button>

        <el-button v-if="edit" @click="edit = false; crudGetOne()" size="mini" type="info">Anuler</el-button>
        <el-button v-if="edit" @click="edit = false; update()" size="mini" type="success">Enrgsiter</el-button>
      </el-button-group>
    </div>

    <!-- ADD MODAL -->
    <el-dialog title="Nouvelle section" :visible.sync="add" width="60%" >
      <div>
        <el-select v-model="section.template">
          <el-option v-for="(options, index) in optsSections" :key="index" :label="options.label" :value="options.value"></el-option>
        </el-select>
        <br/>
        <br/>
        <el-button @click="add = false; createSection()" size="mini" type="success">Créer la séction</el-button>
      </div>
    </el-dialog>

    <div class="cms-content cms-content--page">

      <!-- section item template -->
      <cms-editable-select
      :edit="edit"
      :opts-provider="optsProvider" :opts-mapper="optsMapperTemplate"
      modelStoreName="pages" modelField="template" :modelId="modelId"
      />

      <!-- draggable -->
      <slot></slot>
    </div>

  </div>
</template>

<script>
import edit from '../mixins/ui/edit'
import add from '../mixins/ui/add'
import editable from '../mixins/editable'
import settings from '../mixins/settings'
import Section from '../models/Section'

export default
{
  name: 'cms-page',
  mixins: [edit, add, editable, settings],
  data:()=>({
    section: new Section()
  }),
  created(){ this.model.crud().getOne(this.modelId)},
  computed:
  {
    optsSections() {
      if(!this.entity) return null
      return this.getAllowedTFP(this.modelId).map(this.optsMapperTemplate)
    },
  },
  methods:
  {
    optsProvider() { return this.getTemplatesForKind('pages') },
    createSection()
    {
      // fill in
      this.section.page_id = this.modelField
      this.section.order = _.has(this.entity.sections,'length')? this.entity.sections.length: 0

      // save
      this.section.save(null, null, {relations:[this.entity]})
      .then(data => window.location.reload())
      .catch(err => alert(err))
    }
  }
}
</script>
