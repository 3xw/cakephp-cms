<template lang="html">
  <div class="cms-page">

    <!-- controls -->
    <div class="cms-controls">
      <el-button-group>
        <el-button v-if="!edit" @click="edit = true" size="mini" type="primary" >Editer</el-button>
        <el-button v-if="!edit" @click="crudDelete()" size="mini" type="danger">Effacer</el-button>
        <el-button v-if="!edit" @click="add = true" size="mini" type="success">Ajouter une section</el-button>

        <el-button v-if="edit" @click="edit = false; crudGetOne()" size="mini" type="info">Anuler</el-button>
        <el-button
        v-if="edit"
        @click="$refs['pageForm'].validate(valid => { if(valid){ edit = false; update();} })"
        size="mini" type="success">Enrgsiter</el-button>
      </el-button-group>

      <!-- SETTINGS -->
      <div v-if="edit" class="cms-item-settings">
        <el-form :model="editable" :rules="rules" ref="pageForm" label-width="180px" size="mini">
          <el-form-item label="Template de page" prop="template">
            <el-select v-model="editable.template">
              <el-option v-for="(options, index) in pageTemplates" :key="index" :label="options.label" :value="options.value"></el-option>
            </el-select>
          </el-form-item>

          <el-form-item label="Slug de page" prop="slug">
            <el-input type="textarea" v-model="editable.slug"></el-input>
          </el-form-item>

          <el-form-item label="Metas de page" prop="meta">
            <el-input type="textarea" v-model="editable.meta"></el-input>
          </el-form-item>
        </el-form >
      </div>

      <!-- SLUG -->
      <div v-if="0">
        <el-form ref="form" label-width="300px" size="mini">
          <el-form-item :label="editable.slug+'/'">
            <el-input v-model="newPage.slug"></el-input>
          </el-form-item>
        </el-form>
      </div>

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

      <!-- draggable -->
      <slot name="default" v-bind:edit="edit"></slot>
    </div>

  </div>
</template>

<script>
import edit from '../mixins/ui/edit'
import add from '../mixins/ui/add'
import editable from '../mixins/editable'
import settings from '../mixins/settings'
import Section from '../models/Section'
import Page from '../models/Page'

export default
{
  name: 'cms-page',
  mixins: [edit, add, editable, settings],
  data:()=>({
    section: new Section(),
    newPage: new Page(),
    rules: {
      slug: [{required: true, message: 'Veuillez entrer un slug', trigger: 'blur'}],
      template: [{required: true}]
    },
  }),
  created(){ this.model.crud().getOne(this.modelId)},
  computed:
  {
    optsSections() {
      if(!this.entity) return null
      return this.getAllowedTFP(this.modelId).map(this.optsMapperTemplate)
    },
    pageTemplates(){return this.getTemplatesForKind('pages').map(this.optsMapperTemplate)}
  },
  methods:
  {
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
