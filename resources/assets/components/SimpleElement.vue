<script>
import editable from '../mixins/editable.js'

export default
{
  name: 'cms-simple-element',
  mixins: [editable],
  props:
  {
    elem: String
  },
  render: function (createElement)
  {
    return createElement(this.elem, this.field)
  }
}
</script>
