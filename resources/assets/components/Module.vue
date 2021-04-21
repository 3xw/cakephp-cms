<template lang="html">
  <div class="cms-module">

    <!-- controls -->
    <div class="cms-controls cms-controls--module">
      <div class="d-flex justify-content-between align-items-center px-2">
        <span class="material-icons cms-handle"> reorder </span>
        <p class="small"><strong>{{templateName}}</strong></p>
        <el-button-group>
          <el-button v-if="!edit" @click="edit = true" size="mini" type="primary" >Editer</el-button>
          <el-button v-if="!edit" @click="crudDelete()" size="mini" type="danger">Supprimer</el-button>

          <el-button v-if="edit" @click="edit = false; cancel()" size="mini" type="info">Annuler</el-button>
          <el-button v-if="edit" @click="edit = false; save()" size="mini" type="success">Enregistrer</el-button>
        </el-button-group>
      </div>

      <!-- SETTINGS -->
      <div v-if="edit" class="cms-item-settings">
        <cms-editable-select
        :edit="edit"
        :opts-provider="optsProvider" :opts-mapper="optsMapperCell"
        :modelStoreName="modelStoreName" modelField="cell" :modelId="modelId"
         />
         <cms-editable-meta-select
         :edit="edit"
         :opts-provider="optsParamProvider"
         :modelStoreName="modelStoreName" modelField="meta" :modelId="modelId"
         />
      </div>

    </div>

    <!-- content -->
    <div class="cms-content cms-content--module">
      <!-- module -->
      <slot name="default" v-bind:edit="edit"></slot>
    </div>

  </div>
</template>

<script>
import edit from '../mixins/ui/edit'
import editable from '../mixins/editable'
import settings from '../mixins/settings'

export default
{
  name: 'cms-module',
  mixins: [edit, editable, settings],
  props: {
    sectionItemId: String,
  },
  data: () => ({
    template: null
  }),
  computed:
  {
    SI(){ return this.$store.$db().model('section_items')},
    si(){ return this.SI.find(this.sectionItemId) },
    templateChanged(){ return this.template != this.si.template },
    options(){ return this.getAllowedCFS(this.si.section_id) },
    paramsOptions(){ return this.getModuleOptions(this.si.template) },
    templateName(){ let c = this; return this.options.find(e => e.template === c.si.template ).name}
  },
  watch:
  {
    edit(val)
    {
      if(val) this.template = this.si.template
    },
  },
  created(){
    this.crudGetOne()
    this.paramsOptions()
  },
  methods:
  {
    optsParamProvider() { return this.paramsOptions },
    optsProvider() { return this.options },
    deleted() { window.location.reload()},
    cancel()
    {
      this.crudGetOne() // for article
      if(this.templateChanged) this.SI.crud().getOne(this.sectionItemId)
    },
    save()
    {
      let promises = [this.update()]
      if(this.templateChanged) this.si.update().then(data => window.location.reload())

      Promise.all(promises)
      .then(data => window.location.reload())
      .catch(err => console.log(err))
    }
  }
}
</script>
