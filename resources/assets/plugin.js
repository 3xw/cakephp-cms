import ormPlugin from './store/ormPlugin'
import Page from './components/Page.vue'

const
components = [
  Page
],
install = function(Vue, { store })
{
  // register your own vuex module/plugin
  if (!store) throw new Error("Please provide vuex store.")
  ormPlugin(store)

  // add components
  components.forEach(component => Vue.component(component.name, component))
}

export default
{
  version: '4.0.0',
  install,

  // export compo individually
  Page,
}
