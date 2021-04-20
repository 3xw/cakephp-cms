import { Model, Relation } from '@vuex-orm/core'

export default class ModelWithAttachments extends Model
{

  static query()
  {
    let
    method = this.getters('query')(),
    fields = this.fields()
    for( let key in fields)
    {
      if(fields[key] instanceof Relation) method.with(key)
    }
    return method
  }

  async setAttachments( objs )
  {
    //console.log('modelWithAttachments.setAttachments')

    // clear existing
    let
    article = await this.constructor.find(this.id), // see find override...
    Pivot
    this.constructor.pivotFields().map(f => {if(f.attachments) Pivot = f.attachments.pivot} )
    article.attachments.forEach(a => Pivot.delete([this.id, a.id]))

    if(!objs.length) return

    // create with order in pivot table
    objs = objs.map((obj, i) => Object.assign(obj, { pivot:{order: i} }))
    await this.constructor.insertOrUpdate({data: { id: this.id, attachments: objs }})
  }

  async update(path = null, keys = null, config = null)
  {
    if(this.attachments && this.attachments.length)
    {
      this.attachments = this.attachments.map((e,i) => (Object.assign(e, {
        _joinData: {
          order: e.pivot? e.pivot.order: i
        }
      })))
    }

    return super.update(path, keys, config)
  }
}
