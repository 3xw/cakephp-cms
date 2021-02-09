<template lang="html">

  <!-- edit -->
  <div v-if="edit" class="cms-editable-string-input">
    <input type="text" v-model="field">
  </div>

  <!-- show -->
  <component v-else :is="is" :modelStoreName="modelStoreName" :modelField="modelField" :modelId="modelId" />

</template>

<script>
import mutableInput from '../../mixins/ui/mutableInput.js'
import editable from '../../mixins/editable.js'

export default
{
  name: 'cms-editable-string-input',
  mixins: [mutableInput, editable],
}
</script>
