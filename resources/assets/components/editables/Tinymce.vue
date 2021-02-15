<template lang="html">

  <!-- edit -->
  <div v-if="edit" class="cms-editable-tiptap">
    <el-form label-position="top">
      <el-form-item :label="modelField">

        <editor
         api-key="no-api-key"
         v-model="field"
         :init="{
           height: 500,
           menubar: false,
           plugins: [
             'advlist autolink lists link image charmap print preview anchor',
             'searchreplace visualblocks code fullscreen',
             'insertdatetime media table paste code help wordcount'
           ],
           toolbar:
             'undo redo | formatselect | bold italic backcolor | \
             alignleft aligncenter alignright alignjustify | \
             bullist numlist outdent indent | removeformat | help'
         }"
       />

      </el-form-item>
    </el-form>
  </div>

  <!-- show -->
  <cms-simple-element v-else :elem="elem" :html="true" :modelStoreName="modelStoreName" :modelField="modelField" :modelId="modelId" />

</template>

<script>
import mutableInput from '../../mixins/ui/mutableInput.js'
import editable from '../../mixins/editable.js'
 import Editor from '@tinymce/tinymce-vue'

export default
{
  name: 'cms-editable-tinymce',
  mixins: [mutableInput, editable],
  components: {
   Editor,
 },
  data: () => ({
    editor: new Editor()
  }),
  beforeDestroy() {
    // Always destroy your editor instance when it's no longer needed
    this.editor.destroy()
  }
}
</script>
