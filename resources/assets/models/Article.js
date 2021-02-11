import { Model } from '@vuex-orm/core'
import SectionItem from './SectionItem'

export default class Article extends Model
{
  static entity = 'articles'

  static fields ()
  {
    return {
      id: this.attr(null).nullable(),
      status: this.attr('cms-managed'),
      publish_date: this.attr(new Date()),
      title: this.attr(null),
      header: this.attr(null),
      body: this.attr(null),

      section_item: this.belongsTo(SectionItem, 'foreign_key'),
    }
  }
}
