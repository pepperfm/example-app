import axios from 'axios'

// class AxiosWrapper extends Plugin_2 {
class AxiosWrapper {
  constructor() {
    this.createClient()
  }

  async request(options) {
    const token = localStorage.getItem('accessToken')

    if (this.client.defaults.headers.accessToken !== `Bearer ${token}`) {
      this.createClient()
    }

    return this.client(options)
      .then(this.onSuccess)
      .catch(this.onError)
  }

  async get(path, options) {
    return this.request({ method: 'GET', url: path, ...options })
  }

  async post(path, payload, options) {
    return this.request({
      method: 'POST', url: path, data: payload, ...options,
    })
  }

  async put(path, payload, options) {
    return this.request({
      method: 'PUT', url: path, data: payload, ...options,
    })
  }

  async delete(path, payload, options) {
    return this.request({
      method: 'DELETE', url: path, data: payload, ...options,
    })
  }

  createClient() {
    const token = localStorage.getItem('accessToken')
    let headers = {}

    if (token) {
      headers = { Pragma: 'no-cache', Authorization: `Bearer ${token}` }
    }

    this.client = axios.create({
      // baseURL: "http://localhost:8080/api",
      withCredentials: true,
      headers,
    })
    this.onSuccess = this.onSuccess.bind(this)
    this.onError = this.onError.bind(this)
  }

  // eslint-disable-next-line class-methods-use-this
  onSuccess(response) {
    return response
  }

  onError(error) {
    // FIXME подумать над тем, когда падает авторизация
    if (error.response.status === 401 || error.response.status === 403) {
      // router.push('/login')
      if (this.$vm) {
        this.$vm.$root.$emit('require-auth')
      }
    }

    return Promise.reject(error)
  }
}

export default new AxiosWrapper()
