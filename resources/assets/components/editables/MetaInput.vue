<template lang="html">
  <div class="cms-editable-input-meta">
    <div v-if="edit" >
      <el-form label-position="top">
        <el-form-item :label="modelField">
          <el-input v-model="meta.value"></el-input>
        </el-form-item>
      </el-form>
    </div>
  </div>
</template>
<script>
import mutableInput from '../../mixins/ui/mutableInput.js'
import editable from '../../mixins/editable.js'
import Meta from '../../models/Meta'

export default {
  name: 'cms-editable-input-meta',
  mixins: [mutableInput, editable],
  data: () => ({
    isMeta: true,
  }),
  computed:
  {
    meta(){
      let metaKey = this.entity.metas.findIndex(m => (m.foreign_key === this.entity.id && m.key === this.modelField))
      if(metaKey != -1){
        return this.entity.metas[metaKey]
      }else{
        let meta = new Meta({ model: this.modelStoreName, key: this.modelField, foreign_key: this.modelId, value: '' })
        this.entity.metas.push(meta)
        return this.entity.metas[0];
      }
    }
  }
}
</script>
