import { Model } from '@vuex-orm/core'
import Page from './Page'
import SectionItem from './SectionItem'

export default class Section extends Model
{
  static entity = 'sections'

  static fields ()
  {
    return {
      id: this.attr(null).nullable(),
      page_id: this.attr(null),
      order: this.attr(null),
      template: this.attr('Trois/Cms.sections/default'),

      page: this.belongsTo(Page, 'page_id'),
      section_items: this.hasMany(SectionItem, 'section_id'),
    }
  }
}
