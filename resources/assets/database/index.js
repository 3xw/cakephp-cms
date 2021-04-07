import { Database } from '@vuex-orm/core'

// models
import AttachmentArticle from '../models/AttachmentArticle'
import Attachment from '../models/Attachment'
import Page from '../models/Page'
import Section from '../models/Section'
import SectionItem from '../models/SectionItem'
import Article from '../models/Article'
import Module from '../models/Module'
import Meta from '../models/Meta'

const database = new Database()
database.register(Page)
database.register(Section)
database.register(SectionItem)
database.register(Article)
database.register(Module)
database.register(AttachmentArticle)
database.register(Attachment)
database.register(Meta)

export default database
