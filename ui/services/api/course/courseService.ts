import {PaginationMetaData} from '~/services/api/data/PaginationMeta';
import {GetCourseData} from '~/services/api/course/GetCourseData';
import {GetMetricsData} from '~/services/api/metrics/GetMetricsData';

export const getCourses = async (params?: object) => {
  const response = await useAxios().get('/api/courses', {params})
  return {
    meta: new PaginationMetaData(response?.data?.meta),
    data: response?.data?.data?.map((item: any) => new GetCourseData(item)),
  }
}

export const getCourse = async (id: number|string, params?: object) => {
  const response = await useAxios().get(`/api/courses/${id}`, {params})
  return new GetCourseData(response?.data)
}

export const getCourseMetrics = async () => {
  const response = await useAxios().get(`/api/metrics`)
  return response?.data?.map((item: any) => new GetMetricsData(item))
}

export const createCourse = async ( data: object) => {
  return await useAxios().post(`/api/courses`, data, {
    headers: {
      'Content-Type': 'multipart/form-data',
    },
  })
}

export const updateCourse = async (id: number|string, data: object) => {
  return await useAxios().post(`/api/courses/${id}`, data, {
    headers: {
      'Content-Type': 'multipart/form-data',
    },
  })
}

export const deleteCourse = async (id: number|string) => {
  return await useAxios().delete(`/api/courses/${id}`)
}
