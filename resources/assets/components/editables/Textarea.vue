<template lang="html">

  <!-- edit -->
  <div v-if="edit" class="cms-editable-textarea">
    <el-form label-position="top">
      <el-form-item :label="modelField">
        <el-input type="textarea" v-model="field"></el-input>
      </el-form-item>
    </el-form>
  </div>

  <!-- show -->
  <cms-simple-element v-else :elem="elem" :modelStoreName="modelStoreName" :modelField="modelField" :modelId="modelId" />

</template>

<script>
import mutableInput from '../../mixins/ui/mutableInput.js'
import editable from '../../mixins/editable.js'

export default
{
  name: 'cms-editable-textarea',
  mixins: [mutableInput, editable],
}
</script>
