<script>
import draggable from 'vuedraggable'
import Page from '../models/Page'
import Section from '../models/Section'
import editable from '../mixins/editable'

export default
{
  name: 'cms-draggable',
  mixins: [editable],
  components: { draggable },
  data: () => ({
    list: [], // You can name this whatever you want
    initied: false
  }),
  mounted()
  {
    if(this.entities.length) this.changed()
  },
  methods:
  {
    changed()
    {
      console.log('ready', this.modelStoreName);
      if(!this.$slots.default || this.initied) return

      this.initied = true
      let key = 0
      const filtered = this.$slots.default.filter(
        vnode => vnode.tag !== undefined
      )
      this.list = filtered.map((vnode, index) => ({ id: this.entities[index].id, vnode }))
    },
    dragEnd()
    {
      // synch id and count with store and update items!!
      this.list.map((item, index) =>
      {
        // what we need
        let entity = this.model.find(item.id)
        entity[this.modelField] = index
        entity.update(null,[this.modelField])
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
