import { Model } from '@vuex-orm/core'

export default class Page extends Model
{
  static entity = 'pages'

  static fields ()
  {
    return {
      id: this.attr(null).nullable(),
      title: this.attr(null),
    }
  }
}
