import { Database } from '@vuex-orm/core'

// models
import Page from '../models/Page'
import Section from '../models/Section'
import SectionItem from '../models/SectionItem'
import Article from '../models/Article'
import Module from '../models/Module'
import AttachmentArticle from '../models/AttachmentArticle'
import Attachment from '../models/Attachment'

const database = new Database()
database.register(Page)
database.register(Section)
database.register(SectionItem)
database.register(Article)
database.register(Module)
database.register(AttachmentArticle)
database.register(Attachment)

export default database
