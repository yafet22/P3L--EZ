import axios from 'axios'

export default {
  init() {
    axios.defaults.baseURL = 'http://127.0.0.1/'
  },

  setHeader (token) {
    axios.defaults.headers.common['Authorization'] = 'Basic ' + btoa(token.username + ':' + token.password)
  },

  getHeader () {
    return axios.defaults.headers.common['Authorization']
  },

  get(url) {
    try {
      return axios.request({
        url,
        method: 'get'
      })
    } catch (err) {
      throw err
    }
  },

  download(url) {
    try {
      return axios.request({
        url,
        method: 'get',
        responseType: 'blob'
      }).then(response => {
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'file.pdf'); //or any other extension
        console.log(link)
        document.body.appendChild(link);
        link.click();

        // //Create a Blob from the PDF Stream
        //   const file = new Blob(
        //     [response.data], 
        //     {type: 'application/pdf'});
        // //Build a URL from the file
        //     const fileURL = URL.createObjectURL(file);
        // //Open the URL on new Window
        //     window.open(fileURL);

        })
    } catch (err) {
      throw err
    }
  },

  post(url, data) {
    try {
      return axios.request({
        url,
        data,
        method: 'post'
      })
    } catch (err) {
      throw err
    }
  },

  patch(url, data) {
    try {
      return axios.request({
        url,
        data,
        method: 'patch'
      })
    } catch (err) {
      throw err
    }
  },

  put(url, data) {
    try {
      return axios.request({
        url,
        data,
        method: 'put'
      })
    } catch (err) {
      throw err
    }
  },

  delete(url) {
    try {
      return axios.request({
        url,
        method: 'delete'
      })
    } catch (err) {
      throw err
    }
  }
}