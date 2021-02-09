<template lang="html">
  <div class="cms-article">

    <!-- controls -->
    <div class="cms-controls cms-controls--article">
      <el-button-group>
        <el-button v-if="!edit" @click="edit = true" size="mini" type="primary" >Editer</el-button>
        <el-button v-if="!edit" size="mini" type="danger">Effacer</el-button>

        <el-button v-if="edit" @click="edit = false" size="mini" type="info">Anuler</el-button>
        <el-button v-if="edit" @click="edit = false" size="mini" type="success">Enrgsiter</el-button>
      </el-button-group>
    </div>

    <div class="cms-content cms-content--article">
      <slot v-bind:edit="edit"></slot>
    </div>

  </div>
</template>

<script>
import edit from '../mixins/ui/edit'

export default
{
  name: 'cms-article',
  mixins: [edit],
  props:
  {
    originalArticle: Object
  },
  data:() => ({
    article: null
  }),
  created()
  {
    this.article = this.originalArticle
  }
}
</script>
