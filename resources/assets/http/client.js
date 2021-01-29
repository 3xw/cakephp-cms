import axios from 'axios'

const
Http = axios.create({
  baseURL: BASE_URL,
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
  }
})

export default class client extends Http
{
  static setAuth(token)
  {
    this.defaults.headers.Authorization = token
    return this
  }

  static setBasicAuth(username, password)
  {
    this.setAuth('Basic '+btoa(username + ":" + password))
    return this
  }

  static setBearerAuth(token)
  {
    this.setAuth('Bearer '+token)
    return this
  }
}
