import { Model } from '@vuex-orm/core'
import Section from './Section'

export default class SectionItem extends Model
{
  static entity = 'sectionItems'

  static fields ()
  {
    return {
      id: this.attr(null).nullable(),
      section_id: this.attr(null),
      order: this.attr(null),
      model: this.attr(null),
      foreign_key: this.attr(null),
      template: this.attr(null),

      page: this.belongsTo(Section, 'section_id'),
    }
  }
}
