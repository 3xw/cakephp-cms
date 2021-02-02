import { Model } from '@vuex-orm/core'

export default class Section extends Model
{
  static entity = 'section'

  static fields ()
  {
    return {
      id: this.attr(null).nullable(),
      page_id: this.attr(null),
      template: this.attr(null),
    }
  }
}
