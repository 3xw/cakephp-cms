<template lang="html">

  <!-- edit -->
  <div v-if="edit" class="cms-editable-select">
    <div class="input" v-for="(param, key) in options">
      <el-select v-model="metaData[key]" :placeholder="key" @change="selectUpdate">
        <el-option v-for="(label, value) in param" :key="value" :label="label" :value="value"></el-option>
      </el-select>
    </div>
    <input v-model="field" type="hidden">
  </div>

  <!-- show -->
  <div v-else >
    <slot :modelStoreName="modelStoreName" :modelField="modelField" :modelId="modelId" />
  </div>

</template>

<script>
import mutableInput from '../../mixins/ui/mutableInput.js'
import editable from '../../mixins/editable.js'

export default
{
  name: 'cms-editable-meta-select',
  mixins: [mutableInput, editable],
  props:
  {
    placeholder: String,
    optsProvider: Function,
  },
  created() {
    this.crudGetOne()
  },
  computed:
  {
    metaData()
    {
      if(!this.entity) return {}
      return JSON.parse(this.entity.meta)
    },
    options()
    {
      return this.optsProvider()
    }
  },
  methods: {
    selectUpdate(){
      this.field = JSON.stringify(this.metaData)
    }
  }
}
</script>
