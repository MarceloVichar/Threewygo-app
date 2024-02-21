export const useErrorBag = (formErrors: string[] = [], apiErrors: object = {}, field: string) => {
  const filteredApiErrors = _get(apiErrors, field, [])
  return formErrors.concat(filteredApiErrors)
}
