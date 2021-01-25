import Page from './components/Page.vue'

const
components = [
  Page
],
install = function(Vue, opts = {})
{
  components.forEach(component => Vue.component(component.name, component))
}

export default
{
  version: '4.0.0',
  install,

  // export compo individually
  Page,
}
