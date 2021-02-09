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
      this.$store.$db().model(this.modelStoreName).find(this.modelId)
    }
  }
}
