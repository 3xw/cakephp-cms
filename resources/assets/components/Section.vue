<template lang="html">
  <div class="cms-section">

    <!-- controls -->
    <div class="cms-controls cms-controls--section">
      <el-button-group>
        <el-button v-if="!edit" @click="edit = true" size="mini" type="primary" >Editer</el-button>
        <el-button v-if="!edit" @click="crudDelete()" size="mini" type="danger">Effacer</el-button>
        <el-button v-if="!edit" @click="add = true" size="mini" type="success">Ajouter une element</el-button>

        <el-button v-if="edit" @click="edit = false; crudGetOne()" size="mini" type="info">Anuler</el-button>
        <el-button v-if="edit" @click="edit = false; update()" size="mini" type="success">Enrgsiter</el-button>
      </el-button-group>
    </div>

    <!-- section modal -->
    <el-dialog title="Nouvel element" :visible.sync="add" width="60%" >
      <el-select v-model="type">
        <el-option v-for="(options, index) in optsType" :key="index" :label="options.label" :value="options.value"></el-option>
      </el-select>

      <div v-if="type == 'articles'">
        <h3>Choisir le type d'article</h3>
        <el-select v-model="sectionItem.template">
          <el-option v-for="(options, index) in optsTemplate" :key="index" :label="options.label" :value="options.value"></el-option>
        </el-select>
      </div>

      <div v-if="type == 'modules'">
        <h3>Choisir le type de module</h3>
        <el-select v-model="module.cell">
          <el-option v-for="(options, index) in optsCell" :key="index" :label="options.label" :value="options.value"></el-option>
        </el-select>
      </div>

    </el-dialog>

    <div class="cms-content cms-content--section">

      <!-- section item template -->
      <cms-editable-select
      :edit="edit"
      :opts-provider="optsProvider" :opts-mapper="optsMapperTemplate"
       modelStoreName="sections" modelField="template" :modelId="modelId"
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
    module: new Module()
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
    optsType() { return [{label: 'Nouvel artcile', value: 'articles'}, {label: 'Nouveau module', value: 'modules'}] },
    optsLayout(){ return this.getAllowedTFP(this.entity.page_id) },
    optsTemplate()
    {
      if(!this.entity) return []
      return this.getAllowedTFS(this.modelId).filter(this.optsMapperTemplate)
    },
    optsCell()
    {
      if(!this.entity) return []
      return this.getAllowedCFS(this.modelId).filter(this.optsMapperCell)
    },
    //siModel() { return this.type == 'articles'? 'Article': 'Module' }
  },
  methods:
  {
    optsProvider() { return this.optsLayout },
    deleted() { window.location.reload()},
  }
}
</script>
