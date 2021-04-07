import { Model } from '@vuex-orm/core'
import Article from './Article'
import Module from './Module'

export default class Meta extends Model
{
  static entity = 'metas'

  static fields ()
  {
    return {
      id: this.attr(null).nullable(),
      model: this.attr(null),
      foreign_key: this.attr(null),
      key: this.attr(null),
      value: this.attr(null),

      article: this.hasOne(Article, 'id', 'foreign_key'),
    }
  }
}
