import { Model } from '@vuex-orm/core'
import Section from './Section'

export default class Page extends Model
{
  static entity = 'pages'

  static fields ()
  {
    return {
      id: this.attr(null).nullable(),
      title: this.attr(null),
      template: this.attr(null),
      slug: this.attr(null),
      meta: this.attr(null),
      lft: this.attr(null),
      rght: this.attr(null),
      parent_id: this.attr(null),

      sections: this.hasMany(Section, 'page_id'),
    }
  }
}
