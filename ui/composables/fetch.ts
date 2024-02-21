import axios from 'axios';

export const useAxios = () => {
  const requestHeaders = {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  }

  return axios.create({
    baseURL: useNuxtApp()?.$config?.public?.apiBaseUrl,
    withCredentials: true,
    headers: requestHeaders,
  });
}
