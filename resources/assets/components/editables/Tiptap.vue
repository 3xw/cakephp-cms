<template lang="html">

  <!-- edit -->
  <div v-if="edit" class="cms-editable-tiptap">
    <el-form label-width="120px">
      <el-form-item :label="modelField">
        <editor-content :editor="editor" />
      </el-form-item>
    </el-form>
  </div>

  <!-- show -->
  <cms-simple-element v-else :elem="elem" :html="true" :modelStoreName="modelStoreName" :modelField="modelField" :modelId="modelId" />

</template>

<script>
import mutableInput from '../../mixins/ui/mutableInput.js'
import editable from '../../mixins/editable.js'
import { Editor, EditorContent } from 'tiptap'

export default
{
  name: 'cms-editable-tiptap',
  mixins: [mutableInput, editable],
  components: {
   EditorContent,
 },
  data: () => ({
    editor: new Editor()
  }),
  beforeDestroy() {
    // Always destroy your editor instance when it's no longer needed
    this.editor.destroy()
  },
  mounted()
  {
    this.editor.on('update', this.editorUpdate)
    this.editor.setContent(this.field, 'html')
  },
  methods:
  {
    editorUpdate({getHTML})
    {
      this.field = getHTML
    }
  }
}
</script>
