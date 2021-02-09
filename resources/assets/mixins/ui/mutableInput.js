export default
{
  props:
  {
    shouldBe: String,
    edit: Boolean
  },
  computed:
  {
    is()
    {
      return this.shouldBe
    }
  }
}
