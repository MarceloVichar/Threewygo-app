import {useToast} from 'vue-toastification'

export const useErrorBag = (formErrors: string[] = [], apiErrors: object = {}, field: string) => {
  const filteredApiErrors = _get(apiErrors, field, [])
  return formErrors.concat(filteredApiErrors)
}

export const useNotify = (type = 'success', text = '', options = {}) => {
  const toast = useToast()
  options = {
    hideProgressBar: true,
    ...options,
  }

  return toast[type](text, options)
}
