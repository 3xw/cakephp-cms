import { Database } from '@vuex-orm/core'

// models
import Page from '../models/Page'
import Section from '../models/Section'

const database = new Database()
database.register(Page)
database.register(Section)

export default database
