<script>
import editable from '../mixins/editable.js'

export default
{
  name: 'cms-simple-element',
  mixins: [editable],
  props:
  {
    elem: String,
    html: Boolean
  },
  render: function (ce)
  {
    return this.html?  ce(this.elem, {domProps:{innerHTML:this.field}}): ce(this.elem, this.field)
  }
}
</script>
