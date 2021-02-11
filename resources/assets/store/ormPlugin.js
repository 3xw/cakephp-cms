// VUEX ORM
import VuexORM from '@vuex-orm/core'
import VuexORMCRUD from '@wgr-sa/vuex-orm-crud'
//import VuexORMRelations from '@wgr-sa/vuex-orm-relations'
//import VuexORMCRUDUI from '@wgr-sa/vuex-orm-crud-ui'
import database from '../database'
import client from '../http/client'

// init ORM-CRUD
VuexORM.use(VuexORMCRUD, {client})
//VuexORM.use(VuexORMCRUDUI)
//VuexORM.use(VuexORMRelations)

export default VuexORM.install(database)
