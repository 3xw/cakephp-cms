import { Model } from '@vuex-orm/core'
import Section from './Section'
import Article from './Article'
import Module from './Module'

export default class SectionItem extends Model
{
  static entity = 'section_items'

  static fields ()
  {
    return {
      id: this.attr(null).nullable(),
      section_id: this.attr(null),
      order: this.attr(null),
      model: this.attr(null),
      foreign_key: this.attr(null),
      template: this.attr('Trois/Cms.articles/default'),

      section: this.belongsTo(Section, 'section_id'),
      article: this.hasOne(Article, 'id', 'foreign_key'),
      module: this.hasOne(Module, 'id', 'foreign_key'),
    }
  }
}
