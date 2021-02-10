import _ from 'lodash'

export default
{
  props:
  {
    settings:Object
  },
  methods:
  {
    optsMapperTemplate(elem) { return {label: elem.name, value: elem.template} },

    getKeyFromTemplateName(tmpl, type = 'pages')
    {
      return _.findKey(this.settings.Tree[type], function(o) { return o.template == tmpl })
    },
    getAllowedFor(key)
    {
      if(!_.has(this.settings.Tree, key+'.allowed')) return []
      return _.get(this.settings.Tree, key).allowed.map(k => {
        if(_.has(this.settings.Tree, k)) return _.get(this.settings.Tree, k)
      })
    },
    getAllowedTFP(id){ return this.getAllowedTemplatesForPageId(id) },
    getAllowedTemplatesForPageId(id)
    {
      let tmpl = this.$store.$db().model('pages').find(id).template
      if(!tmpl) return []

      let key = this.getKeyFromTemplateName(tmpl, 'pages')
      return this.getAllowedFor('pages.'+key)
    },
    getAllowedTFS(id){ return this.getAllowedTemplatesOrCellForSectionId(id, 'article') },
    getAllowedCFS(id){ return this.getAllowedTemplatesOrCellForSectionId(id, 'module') },
    getAllowedTemplatesOrCellForSectionId(id, type = 'both')
    {
      let tmpl = this.$store.$db().model('sections').find(id).template
      if(!tmpl) return []

      let key = this.getKeyFromTemplateName(tmpl, 'sections')
      let allowed = this.getAllowedFor('sections.'+key)
      return allowed.filter(elem => {
        switch(type)
        {
          case 'article':
          if(elem.template) return true;
          break

          case 'module':
          if(elem.cell) return true;
          break

          default:
          return true;
        }
      })
    }
  }
}
