export const createVideo = async ( data: object) => {
  return await useAxios().post(`/api/videos`, data, {
    headers: {
      'Content-Type': 'multipart/form-data',
    },
  })
}

export const updateVideo = async (id: number|string, data: object) => {
  return await useAxios().post(`/api/videos/${id}`, data, {
    headers: {
      'Content-Type': 'multipart/form-data',
    },
  })
}

export const deleteVideo = async (id: number|string) => {
  return await useAxios().delete(`/api/videos/${id}`)
}
