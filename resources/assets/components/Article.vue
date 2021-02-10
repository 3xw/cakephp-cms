<template lang="html">
  <div class="cms-article">

    <!-- controls -->
    <div class="cms-controls cms-controls--article">
      <el-button-group>
        <el-button v-if="!edit" @click="edit = true" size="mini" type="primary" >Editer</el-button>
        <el-button v-if="!edit" @click="crudDelete()" size="mini" type="danger">Effacer</el-button>

        <el-button v-if="edit" @click="edit = false; cancel()" size="mini" type="info">Anuler</el-button>
        <el-button v-if="edit" @click="edit = false; update()" size="mini" type="success">Enrgsiter</el-button>
      </el-button-group>
    </div>

    <!-- content -->
    <div class="cms-content cms-content--article">
      <slot name="section-item" v-bind:edit="edit"></slot>
      <slot name="default" v-bind:edit="edit"></slot>
    </div>

  </div>
</template>

<script>
import edit from '../mixins/ui/edit'
import editable from '../mixins/editable'

export default
{
  name: 'cms-article',
  mixins: [edit, editable],
  props: {
    sectionItemId: String,
  },
  computed:
  {
    SectionItem()
    {
      return this.$store.$db().model('section_items')
    }
  },
  methods:
  {
    deleted()
    {
      window.location.reload()
    },
    cancel()
    {
      this.crudGetOne() // for article
      this.SectionItem.crud().getOne(this.sectionItemId)
    }
  }
}
</script>
