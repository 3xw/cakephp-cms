import ormPlugin from './store/ormPlugin'
import Page from './components/Page'
import Scetion from './components/Section'

const
components = [
  Page, Scetion
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
  Scetion,
}
