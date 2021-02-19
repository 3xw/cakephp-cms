import { Model } from '@vuex-orm/core'
import moment from 'moment'

export default class Attachment extends Model
{
  static entity = 'attachments'

  static fields ()
  {
    return {
      id: this.attr(null).nullable(),

      profile: this.attr(null),
      type: this.attr(null),
      subtype: this.attr(null),
      name: this.attr(null),
      size: this.attr(null),
      md5: this.attr(null),
      path: this.attr(null),
      embed: this.attr(null),
      title: this.attr(null),
      date: this.attr(moment().format()),
      description: this.attr(null),
      author: this.attr(null),
      copyright: this.attr(null),
      width: this.attr(null),
      height: this.attr(null),
      duration: this.attr(null),
      meta: this.attr(null),

      _joinData: this.attr(null),

    }
  }
}
