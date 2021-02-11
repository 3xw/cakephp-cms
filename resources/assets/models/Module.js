import { Model } from '@vuex-orm/core'
import SectionItem from './SectionItem'

export default class Module extends Model
{
  static entity = 'modules'

  static fields ()
  {
    return {
      id: this.attr(null).nullable(),
      name: this.attr(null),
      cell: this.attr('Trois/Cms.Default::display'),

      section_item: this.belongsTo(SectionItem, 'foreign_key'),
    }
  }
}
