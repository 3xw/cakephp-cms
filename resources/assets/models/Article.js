import ModelWithAttachments from './ModelWithAttachments'

import SectionItem from './SectionItem'
import Attachment from './Attachment'
import AttachmentArticle from './AttachmentArticle'
import moment from 'moment'

export default class Article extends ModelWithAttachments
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
      meta: this.attr(null),

      section_item: this.belongsTo(SectionItem, 'foreign_key'),
      attachments: this.belongsToMany(Attachment, AttachmentArticle, 'article_id', 'attachment_id'),
    }
  }
}
