import { Model } from '@vuex-orm/core'
import AttachmentArticle from './AttachmentArticle'

export default class ModelWithAttachments extends Model
{
  async setAttachments( objs )
  {
    console.log('modelWithAttachments.setAttachments')

    // clear existing
    let article = await this.constructor.query().whereId(this.id).with('attachments').first()
    article.attachments.forEach(a => AttachmentArticle.delete([this.id, a.id]))

    if(!objs.length) return

    // create with order in pivot table
    objs = objs.map((obj, i) => Object.assign(obj, { pivot:{order: i} }))
    await this.constructor.insertOrUpdate({data: { id: this.id, attachments: objs }})
  }

  async updateWithAttachments(path = null, keys = null, config = null)
  {
    let entity = this
    console.log(entity);
    entity.attachments = entity.attachments.map((e,i) => ({
      id: e.id,
      _joinData: {
        order: e.pivot? e.pivot.order: i
      }
    }))

    return entity.update(path, keys, config)
  }
}
