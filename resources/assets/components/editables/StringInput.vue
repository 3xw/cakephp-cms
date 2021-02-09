<template lang="html">

  <div v-if="edit" class="cms-editable-string-input">
    <!-- edit -->
    {{field}}
    <!-- show -->
  </div>

  <component
  v-else
  :is="is"
  :modelStoreName="modelStoreName"
  :modelField="modelField"
  :modelId="modelId"
  >
  </component>

</template>

<script>
import edit from '../../mixins/ui/edit.js'
import editable from '../../mixins/editable.js'

export default
{
  name: 'cms-editable-string-input',
  mixins: [edit,editable],
  props:
  {
    shouldBe: String
  },
  computed:
  {
    is()
    {
      return this.shouldBe
    }
  }
}
</script>
