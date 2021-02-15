<template lang="html">

  <!-- edit -->
  <div v-if="edit" class="cms-editable-textarea">
    <el-form label-position="top">
      <el-form-item :label="modelField">

        <slot />

      </el-form-item>
    </el-form>
  </div>

  <!-- show -->

</template>

<script>
import mutableInput from '../../mixins/ui/mutableInput.js'
import editable from '../../mixins/editable.js'

export default
{
  name: 'cms-editable-attachment',
  mixins: [mutableInput, editable],
}
</script>
