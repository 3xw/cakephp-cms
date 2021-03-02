import './assets/scss/theme.scss'

import ormPlugin from './store/ormPlugin'

// COMPONENTS
import Page from './components/Page'
import Draggable from './components/Draggable'
import Section from './components/Section'
import Article from './components/Article'
import Module from './components/Module'
import SimpleElement from './components/SimpleElement'
import InputText from './components/editables/InputText'
import Textarea from './components/editables/Textarea'
import Select from './components/editables/Select'
import MetaSelect from './components/editables/MetaSelect'
import Tiptap from './components/editables/Tiptap'
import Slot from './components/editables/Slot'

const
components = [
  Page, Draggable, Section, Article, Module, SimpleElement,
  InputText, Textarea, Select, MetaSelect, Tiptap, Slot
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
}
