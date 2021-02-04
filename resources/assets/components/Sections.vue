<script>
// https://dev.to/athif23/how-to-make-vue-draggable-work-with-different-structure-of-elements-components-1729
import draggable from 'vuedraggable'

export default
{
  name: 'cms-sections',
  components: { draggable },
  props:{
    sections: Array
  },
  data: () => ({
    items: [],
    list: [] // You can name this whatever you want
  }),
  created()
  {
    this.items = this.sections
    //this.$attrs['v-model'] = 'items'
  },
  mounted ()
  {
    if(!this.$slots.default) return

    // You can change this `key` variable to whatever you want,
    // but it must be unique.
    let key = 0
    const filtered = this.$slots.default.filter(
      vnode => vnode.tag !== undefined
    )
    console.log(filtered);
    this.list = filtered.map(vnode => ({ id: key++, vnode }))
  },
  methods:
  {
    dragEnd()
    {
      console.log(this.list)
    }
  },
  render (h)
  {
    return h('draggable', {
      props: { ...this.$attrs, value: this.list },
      on: {
        input: ($event) => { this.list = $event },
        end: () => this.dragEnd()
      }
    }, this.list.map(el => {
      el.vnode.key = el.id
      return el.vnode
    }))
  }
}
</script>
