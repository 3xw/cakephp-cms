<template lang="html">
  <div class="cms-section">

    <!-- CONTROLS -->
    <div class="cms-controls cms-controls--section">
      <div class="d-flex justify-content-between align-items-center px-2">
        <span class="material-icons cms-handle"> reorder </span>
        <p class="small"><strong>Section</strong></p>
        <el-button-group>
          <!--<el-button v-if="!edit" @click="edit = true" size="mini" type="primary" >Editer</el-button>-->
          <el-button v-if="!edit" @click="setDefaultTemplate();add = true" size="mini" type="success">Ajouter un élément</el-button>
          <el-button v-if="!edit" @click="crudDelete()" size="mini" type="danger">Supprimer</el-button>

          <el-button v-if="edit" @click="edit = false; crudGetOne()" size="mini" type="info">Annuler</el-button>
          <el-button v-if="edit" @click="edit = false; update()" size="mini" type="success">Enregistrer</el-button>
        </el-button-group>
      </div>
      <!-- SETTINGS -->
      <div v-if="edit" class="cms-item-settings">
        <cms-editable-select
        :edit="edit"
        :opts-provider="optsProvider" :opts-mapper="optsMapperTemplate"
         modelStoreName="sections" modelField="template" :modelId="modelId"
         />
      </div>

    </div>

    <!-- ADD MODAL -->
    <el-dialog title="Nouvel element" :visible.sync="add" width="60%" >

      <!-- ELEM TYPE -->
      <el-form label-width="120px">
        <el-form-item label="Type d'élément">
          <el-select v-model="type">
            <el-option v-for="(options, index) in optsType" :key="index" :label="options.label" :value="options.value"></el-option>
          </el-select>
        </el-form-item>
      </el-form >

      <!-- ADD ARTICLE -->
      <div v-if="type == 'articles' && optsTemplate.length">
        <el-form :model="articleForm" :rules="articleRules" ref="articleForm" label-width="120px" >

          <el-form-item label="Type d'article" prop="template">
            <el-select v-model="articleForm.template">
              <el-option v-for="(options, index) in optsTemplate" :key="index" :label="options.label" :value="options.value"></el-option>
            </el-select>
          </el-form-item>

          <el-form-item label="Titre" prop="title">
            <el-input required placeholder="Titre d'article" v-model="articleForm.title"></el-input>
          </el-form-item>

          <el-form-item>
            <el-button @click="$refs['articleForm'].validate(valid => { if(valid){ add = false; createArticle();} })" size="mini" type="success">Créer l'article</el-button>
          </el-form-item>
        </el-form>
      </div>

      <!-- ADD MODULE -->
      <div v-if="type == 'modules' && optsCell.length">
        <el-form label-width="120px" >
          <el-form-item label="Type de module" prop="template">
            <el-select v-model="module.cell">
              <el-option v-for="(options, index) in optsCell" :key="index" :label="options.label" :value="options.value"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item>
            <el-button @click="add = false; createModule()" size="mini" type="success">Créer le module</el-button>
          </el-form-item>
        </el-form>
      </div>

    </el-dialog>

    <div class="cms-content cms-content--section">
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
import SectionItem from '../models/SectionItem'
import Article from '../models/Article'
import Module from '../models/Module'

export default
{
  name: 'cms-section',
  mixins: [edit, add, editable, settings],
  data: () => ({
    type: 'articles',
    sectionItem: new SectionItem(),
    article: new Article(),
    articleForm: {
      template: 'Trois/Cms.articles/default',
      title: null
    },
    articleRules: {
      title: [{required: true, message: 'Veuillez entrer un titre', trigger: 'blur'}],
      template: [{required: true}]
    },
    module: new Module(),
  }),
  mounted()
  {
    this.sectionItem.section_id = this.modelId
  },
  computed:
  {
    SI() { return this.$store.$db().model('section_items') },
    sItems() { return this.SI.query().where('section_id', this.modelId).get() },
    siCount() { return this.sItems.length },
    optsType() { return [{label: 'Nouvel article', value: 'articles'}, {label: 'Nouveau module', value: 'modules'}] },
    optsLayout(){ return this.getAllowedTFP(this.entity.page_id) },
    optsTemplate(){ return this.getAllowedTFS(this.modelId).map(this.optsMapperTemplate) },
    optsCell() { return this.getAllowedCFS(this.modelId).map(this.optsMapperCell) },
  },
  methods:
  {
    optsProvider() { return this.optsLayout },
    deleted() { window.location.reload()},
    setDefaultTemplate(){
      if(this.optsTemplate.length) this.articleForm.template = this.optsTemplate[0].value
      if(this.optsCell.length) this.module.cell = this.optsCell[0].value
    },
    createArticle()
    {
      // fill in
      this.sectionItem.order = this.siCount
      this.sectionItem.template = this.articleForm.template
      this.article.title = this.articleForm.title
      this.article.section_item = this.sectionItem

      // save
      this.article.save()
      .then(data => window.location.reload())
      .catch(err => alert(err))
    },
    createModule()
    {
      // fill in
      let opt = this.optsCell.find(e => e.value == this.module.cell)
      this.sectionItem.order = this.siCount
      this.sectionItem.template = opt.template
      this.module.name = opt.label
      this.module.meta = '{}'
      this.module.section_item = this.sectionItem

      // save
      this.module.save()
      .then(data => window.location.reload())
      .catch(err => alert(err))
    }
  }
}
</script>
