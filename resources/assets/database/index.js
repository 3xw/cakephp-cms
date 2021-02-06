import { Database } from '@vuex-orm/core'

// models
import Page from '../models/Page'
import Section from '../models/Section'
import SectionItem from '../models/SectionItem'

const database = new Database()
database.register(Page)
database.register(Section)
database.register(SectionItem)

export default database
