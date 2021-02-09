<template lang="html">

  <!-- edit -->
  <div v-if="edit" class="cms-editable-textarea">
    <textarea v-model="field"></textarea>
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
