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
    console.log('article.setAttachments',objs)

    // clear existing
    let article = await this.constructor.query().whereId(this.id).with('attachments').first()
    article.attachments.forEach(a => AttachmentArticle.delete([this.id, a.id]))

    if(!objs.length) return

    // create with order in pivot table
    objs = objs.map((obj, i) => Object.assign(obj, { pivot:{order: i} }))
    await this.constructor.insertOrUpdate({data: { id: this.id, attachments: objs }})
  }
}
