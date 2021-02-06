<script>
// https://dev.to/athif23/how-to-make-vue-draggable-work-with-different-structure-of-elements-components-1729
import draggable from 'vuedraggable'
import Page from '../models/Page'
import Section from '../models/Section'

export default
{
  name: 'cms-sections',
  components: { draggable },
  props:{
    sections: Array
  },
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
    this.list = filtered.map((vnode, index) => ({ id: this.sections[index].id, vnode }))
  },
  methods:
  {
    dragEnd()
    {
      // synch id and count with store and update items!!
      this.list.map((item, index) =>
      {
        // what we need
        let section = Section.find(item.id)
        let page = Page.find(section.page_id)

        // set & update
        section.order = index
        section.update(null,['order'],{relations:[page]})
        .catch(err => console.log(err))
      })
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
