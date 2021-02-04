import { Model } from '@vuex-orm/core'
import Page from './Page'

export default class Section extends Model
{
  static entity = 'section'

  static fields ()
  {
    return {
      id: this.attr(null).nullable(),
      page_id: this.attr(null),
      order: this.attr(null),
      template: this.attr(null),

      page: this.belongsTo(Page, 'page_id'),
    }
  }
}
