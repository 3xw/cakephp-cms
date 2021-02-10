<template lang="html">

  <!-- edit -->
  <div v-if="edit" class="cms-editable-select">
    <el-select v-model="field" placeholder="Choisir un type de template" >
      <el-option v-for="(options, index) in options" :key="index" :label="options.label" :value="options.value"></el-option>
    </el-select>
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
  name: 'cms-editable-select',
  mixins: [mutableInput, editable],
  props:
  {
    placeholder: String,
    optsFilter: Function,
    optsMapper: Function,
    optsProvider: Function,
  },
  computed:
  {
    rawOptions()
    {
      if(this.optsProvider) return this.optsProvider()
      return []
    },
    options()
    {
      if(!this.rawOptions) return []
      let opts = this.rawOptions
      if(this.optsFilter) opts = opts.filter(this.optsFilter)
      if(this.optsMapper) opts = opts.map(this.optsMapper)
      return opts
    }
  }
}
</script>
