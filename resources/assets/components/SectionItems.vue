<script>
import draggable from 'vuedraggable'
import Page from '../models/Page'
import Section from '../models/Section'
import SectionItem from '../models/SectionItem'

export default
{
  name: 'cms-section-items',
  components: { draggable },
  props:{
    sectionItems: Array
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
    this.list = filtered.map((vnode, index) => ({
      id: this.sectionItems[index].id,
      section_id: this.sectionItems[index].section_id,
      vnode,
    }))
  },
  methods:
  {
    dragEnd()
    {
      // synch id and count with store and update items!!
      this.list.map((item, index) =>
      {
        // what we need
        let sectionItem = SectionItem.find(item.id)
        let section = Section.find(item.section_id)
        let page = Page.find(section.page_id)

        // set & update
        sectionItem.order = index
        sectionItem.update(null,['order'],{relations:[page, section]})
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
