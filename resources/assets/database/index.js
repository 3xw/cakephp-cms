import { Database } from '@vuex-orm/core'
// models
import Page from '../models/Page'

const database = new Database()
database.register(Page)


export default database
