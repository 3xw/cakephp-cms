import { Model } from '@vuex-orm/core'
import SectionItem from './SectionItem'
import Attachment from './Attachment'
import AttachmentArticle from './AttachmentArticle'
import moment from 'moment'

export default class Article extends Model
{
  static entity = 'articles'

  static fields ()
  {
    return {
      id: this.attr(null).nullable(),
      status: this.attr('cms-managed'),
      publish_date: this.attr(moment().format()),
      title: this.attr(null),
      header: this.attr(null),
      body: this.attr(null),

      section_item: this.belongsTo(SectionItem, 'foreign_key'),
      attachments: this.belongsToMany(Attachment, AttachmentArticle, 'article_id', 'attachment_id'),
    }
  }

  async setAttachments( objs )
  {
    switch(objs.length)
    {
      case 0:
        // delete pivot !
        let article = await this.constructor.query().whereId(this.id).with('attachments').first()
        article.attachments.forEach(a => AttachmentArticle.delete([this.id, a.id]))
        break;

      default:
        await this.constructor.insertOrUpdate({data: { id: this.id, attachments: objs }})
        break;
    }
  }
}
