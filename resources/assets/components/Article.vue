<template lang="html">
  <div class="cms-article">

    <!-- controls -->
    <div class="cms-controls cms-controls--article">
      <el-button-group>
        <el-button v-if="!edit" @click="edit = true" size="mini" type="primary" >Editer</el-button>
        <el-button v-if="!edit" @click="crudDelete()" size="mini" type="danger">Effacer</el-button>

        <el-button v-if="edit" @click="edit = false; cancel()" size="mini" type="info">Anuler</el-button>
        <el-button v-if="edit" @click="edit = false; save()" size="mini" type="success">Enrgsiter</el-button>
      </el-button-group>

      <!-- SETTINGS -->
      <div v-if="edit" class="cms-item-settings">
        <cms-editable-select
        :edit="edit"
        :opts-provider="optsProvider" :opts-mapper="optsMapperTemplate"
         modelStoreName="section_items" modelField="template" :modelId="sectionItemId"
         />
      </div>

    </div>

    <!-- content -->
    <div class="cms-content cms-content--article">

      <!-- article -->
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
  name: 'cms-article',
  mixins: [edit, editable, settings],
  props: {
    sectionItemId: String,
  },
  data: () => ({
    template: null
  }),
  computed:
  {
    entity()
    {
      if(!this.modelId) return null
      this.editable = this.model.query().whereId(this.modelId).with('attachments').first()
      return this.editable
    },
    attachments(){ return this.$store.$db().model('attachments').all() },
    SI(){ return this.$store.$db().model('section_items')},
    si(){ return this.SI.find(this.sectionItemId) },
    templateChanged(){ return this.template != this.si.template },
    options(){ return this.getAllowedTFS(this.si.section_id) }
  },
  watch:
  {
    edit(val)
    {
      if(val) this.template = this.si.template
    }
  },
  mounted()
  {

  },
  methods:
  {
    update()
    {
      this.editable.updateWithAttachments()
      .catch(err => console.log(err))
    },
    optsProvider() { return this.options },
    deleted() { window.location.reload()},
    cancel()
    {
      this.crudGetOne() // for article
      if(this.templateChanged) this.SI.crud().getOne(this.sectionItemId)
    },
    save()
    {
      this.update()
      if(this.templateChanged) this.si.update().then(data => window.location.reload())
    }
  }
}
</script>
