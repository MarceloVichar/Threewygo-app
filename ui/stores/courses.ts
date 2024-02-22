import type {GetCourseData} from '~/services/api/course/GetCourseData';
import {getCourse} from '~/services/api/course/courseService';
import type {GetVideoData} from '~/services/api/video/GetVideoData';

export const useCourses = defineStore('courses', {
  state: () => ({
    currentCourse: {} as GetCourseData,
  }),
  actions: {
    async getCourse(id: string|number) {
      this.currentCourse = await getCourse(id)
    },
    getVideoById(id: string|number): GetVideoData | null {
      return this.currentCourse?.videos?.find((video) => video.id === id) || null
    },
    async ensureCourse(id: string | number) {
      if (this.currentCourse?.id !== parseInt(id.toString())) {
        await this.getCourse(id)
      }
    },
  },
})
