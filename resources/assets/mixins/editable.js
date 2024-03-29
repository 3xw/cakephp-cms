export default
{
  data()
  {
    return {
      editable: null,
    }
  },
  props:
  {
    modelStoreName: String,
    modelField: String,
    modelId: String,
    modelIds: Array,
  },
  computed:
  {
    model()
    {
      if(!this.modelStoreName) return null
      return this.$store.$db().model(this.modelStoreName)
    },
    entity()
    {
      if(!this.modelId) return null
      return this.model.query().where(entity => ( entity.id == this.modelId )).first()
    },
    entities()
    {
      if(!this.modelIds) return null
      return this.model.query().orderBy(this.modelField).whereIdIn(this.modelIds).get()
    },
    field:
    {
      get()
      {
        if(!this.editable) return null
        return _.get(this.editable,this.modelField)
      },
      set(val)
      {
        if(!this.editable) return null
        _.set(this.editable,this.modelField, val)
        this.model.update({
          where: this.modelId,
          data: this.editable
        })
      }
    }
  },
  watch:
  {
    entity(val)
    {
      if(val)
      {

        this.changed()
        this.editable = val
      }
    },
    entities(val)
    {
      if(val) this.changed()
    }
  },
  methods:
  {
    // callbacks
    changed(){},
    deleted(){},

    update()
    {
      return this.entity.update()
    },
    crudGetOne()
    {
      return this.model.crud().getOne(this.modelId)
    },
    crudDelete()
    {
      if(!confirm('Voulez-vous vraiement effacer l\'enregistrement ?')) return
      this.entity.delete()
      .then(this.deleted)
      .catch(err => console.log(err))
    }
  }
}
