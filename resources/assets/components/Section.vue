<template lang="html">
  <div class="cms-section">

    <!-- controls -->
    <div class="cms-controls cms-controls--section">
      <el-button-group>
        <el-button size="mini" type="primary" >Editer</el-button>
        <el-button size="mini" type="danger">Effacer</el-button>
        <el-button size="mini" type="success">Ajouter un element</el-button>
      </el-button-group>
    </div>

    <div class="cms-content cms-content--section">
      <slot></slot>
    </div>

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
