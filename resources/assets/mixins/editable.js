export default
{
  data()
  {
    return {
      editable: null
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
      return this.$store.$db().model(this.modelStoreName)
    },
    entity()
    {
      if(!this.modelId) return null
      this.editable = this.model.find(this.modelId)
      return this.editable
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
        if(!this.entity) return null
        return this.entity[this.modelField]
      },
      set(val)
      {
        this.editable[this.modelField] = val
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
      if(val) this.changed()
      //this.editable = entity
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
      this.editable.update()
      .catch(err => console.log(err))
    },
    crudGetOne()
    {
      this.model.crud().getOne(this.modelId)
      .catch(err => console.log(err))
    },
    crudDelete()
    {
      if(!confirm('Voulez-vous vraiement effacer l\'enregistrement ?')) return
      this.editable.delete()
      .then(this.deleted)
      .catch(err => console.log(err))
    }
  }
}
