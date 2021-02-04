<script>
import draggable from 'vuedraggable'

export default
{
  name: 'cms-section-items',
  components: { draggable },
  data: () => ({
    list: [] // You can name this whatever you want
  }),
  mounted ()
  {
    if(!this.$slots.default) return

    // You can change this `key` variable to whatever you want,
    // but it must be unique.
    let key = 0
    const filtered = this.$slots.default.filter(
      vnode => vnode.tag !== undefined
    )
    this.list = filtered.map(vnode => ({ id: key++, vnode }))
  },
  render (h)
  {
    return h('draggable', {
      props: { ...this.$attrs, value: this.list },
      on: {
        input: ($event) => { this.list = $event },
        end: () => console.log('end')
      }
    }, this.list.map(el => {
      el.vnode.key = el.id
      return el.vnode
    }))
  }
}
</script>
