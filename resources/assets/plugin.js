import './assets/scss/theme.scss'

import ormPlugin from './store/ormPlugin'

// COMPONENTS
import draggable from 'vuedraggable'
import Page from './components/Page'
import Sections from './components/Sections'
import Section from './components/Section'
import SectionItems from './components/SectionItems'
import Article from './components/Article'

const
components = [
  draggable, Page, Sections, Section, SectionItems, Article
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
  Sections,
  Section,
  SectionItems,
  Article
}
