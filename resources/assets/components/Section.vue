<template lang="html">
  <div class="cms-section">

    <!-- controls -->
    <div class="cms-controls cms-controls--section">
      <el-button-group>
        <el-button v-if="!edit" @click="edit = true" size="mini" type="primary" >Editer</el-button>
        <el-button v-if="!edit" @click="crudDelete()" size="mini" type="danger">Effacer</el-button>

        <el-button v-if="edit" @click="edit = false; crudGetOne()" size="mini" type="info">Anuler</el-button>
        <el-button v-if="edit" @click="edit = false; update()" size="mini" type="success">Enrgsiter</el-button>
      </el-button-group>
    </div>

    <div class="cms-content cms-content--section">

      <!-- section item template -->
      <cms-editable-select
      :edit="edit"
      :opts-provider="optsProvider" :opts-mapper="optsMapperTemplate"
       modelStoreName="sections" modelField="template" :modelId="modelId"
       />

      <slot></slot>
    </div>

  </div>
</template>

<script>
import edit from '../mixins/ui/edit'
import editable from '../mixins/editable'
import settings from '../mixins/settings'

export default
{
  name: 'cms-section',
  mixins: [edit, editable, settings],
  computed:
  {
    options(){ return this.getAllowedTFP(this.entity.page_id) }
  },
  methods:
  {
    optsProvider() { return this.options },
    deleted() { window.location.reload()},
  }
}
</script>
