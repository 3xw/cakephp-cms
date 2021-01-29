// VUEX ORM
import VuexORM from '@vuex-orm/core'
import VuexORMCRUD from '@wgr-sa/vuex-orm-crud'
import database from '../database'
import client from '../http/client'

// init ORM-CRUD
VuexORM.use(VuexORMCRUD, {client})

export default VuexORM.install(database)
