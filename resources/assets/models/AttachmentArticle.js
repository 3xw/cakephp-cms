import { Model } from '@vuex-orm/core'
import Attachment from './Attachment'
import Article from './Article'
import moment from 'moment'

export default class AttachmentArticle extends Model
{
  static entity = 'attachmentsArticles'

  static primaryKey = ['article_id', 'attachment_id']

  static fields ()
  {
    return {
      article_id: this.attr(null).nullable(),
      attachment_id: this.attr(null).nullable(),
      order: this.attr(0),
    }
  }
}
