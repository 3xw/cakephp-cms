export default
{
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
      return this.model.find(this.modelId)
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
        this.entity[this.modelField] = val
        this.model.update({
          where: this.modelId,
          data: this.entity
        })
      }
    }
  },
  watch:
  {
    entity(val)
    {
      if(val) this.changed()
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
      this.entity.update()
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
      this.entity.delete()
      .catch(err => console.log(err))
      .then(this.deleted)
    }
  }
}
