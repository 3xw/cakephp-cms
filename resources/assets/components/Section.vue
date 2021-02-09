<template lang="html">
  <div class="cms-section">

    <!-- controls -->
    <div class="control">
      <el-button-group>
        <el-button size="mini" type="primary" >Editer</el-button>
        <el-button size="mini" type="danger">Effacer</el-button>
        <el-button size="mini" type="success">Ajouter un element</el-button>
      </el-button-group>
    </div>

      <slot></slot>

  </div>
</template>

<script>
export default
{
  name: 'cms-section',
  props:
  {
    //originalSection: Object
  }
}
</script>
