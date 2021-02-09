export default
{
  props:
  {
    modelStoreName: String,
    modelField: String,
    modelId: String
  },
  data:() => ({
    //entity: null
  }),
  computed:
  {
    entity()
    {
      return this.$store.$db().model(this.modelStoreName).find(this.modelId)
    },
    field:
    {
      get()
      {
        if(this.entity) return this.entity[this.modelField]
        return null
      },
      set(value)
      {
        console.log(value);
      }
    }
  }
}
