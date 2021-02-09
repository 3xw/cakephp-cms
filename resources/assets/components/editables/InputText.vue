<template lang="html">

  <!-- edit -->
  <div v-if="edit" class="cms-editable-input-text">
    <input type="text" v-model="field">
  </div>

  <!-- show -->
  <cms-simple-element v-else :elem="elem" :modelStoreName="modelStoreName" :modelField="modelField" :modelId="modelId" />

</template>

<script>
import mutableInput from '../../mixins/ui/mutableInput.js'
import editable from '../../mixins/editable.js'

export default
{
  name: 'cms-editable-input-text',
  mixins: [mutableInput, editable],
}
</script>
