import _ from 'lodash'
import client from '../http/client.js'

export default
{
  props:
  {
    settings:Object
  },
  methods:
  {
    optsMapperTemplate(elem) { return {label: elem.name, value: elem.template} },
    optsMapperCell(elem) { return {label: elem.name, value: elem.cell, template: elem.template} },

    getTemplatesForKind($kind)
    {
      let settings = _.get(this.settings.Tree, $kind)
      let templates = []
      _.forOwn(settings, (value, key) => { templates.push(value) })
      return templates
    },
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
          if(!elem.cell) return true;
          break

          case 'module':
          if(elem.cell) return true;
          break

          default:
          return true;
        }
      })
    },
    getModuleOptions(moduleKey)
    {
      let options = {}
      if(!this.settings.Tree.modules[moduleKey].hasOwnProperty('params')) return false

      let params = this.settings.Tree.modules[moduleKey]['params']
      for(const [key, param] of Object.entries(params)) {
        if(param.type == 'list'){
          params[key] = param.options
        }else{
          let controller = param.options.split('::')[0].toLowerCase()
          let action = param.options.split('::')[1]
          client.get(controller+'/'+action, { baseURL: BASE_URL + 'api/', })
          .then(function (response) {
            params[key] = response.data[controller]
          })
          .catch(function (error) { console.log(error); })
          .then(function(){
            return params;
          })
        }
      }
      return params
    }
  }
}
