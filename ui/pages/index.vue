<template>
  <div class="w-full">
    <div class="flex justify-between gap-2 items-center my-2 w-full">
      <h2 class="text-center font-bold text-2xl ">
        Meus cursos
      </h2>
      <button class="btn btn-primary" @click="createCourse">
        Adicionar curso
      </button>
    </div>
    <div v-if="pending" class="flex justify-center my-8">
      <Loader />
    </div>
    <div v-else>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 w-full">
        <CourseCard
          v-for="course in data?.data"
          :key="course.id"
          :item="course"
          @edit="updateCourse"
          @delete="deleteCourse"
        />
      </div>
      <Pagination
        v-if="data?.meta?.total > data?.meta?.per_page"
        class="my-3"
        :current-page="data?.meta?.current_page"
        :items-per-page="data?.meta?.per_page"
        :total-items="data?.meta?.total"
        @changePage="currentPage = $event"
      />
    </div>
    <component
      :is="modal.component"
      v-if="modal.component"
      :data="modal.data"
      @close="modal.component = null"
      @refresh="refresh"
    />
  </div>
</template>

<script setup lang="ts">
import {getCourses} from '~/services/api/course/courseService';
import CourseCard from '~/components/app/courses/CourseCard.vue';
import CreateCourseComponent from '~/components/app/courses/CreateCourse.vue';
import DeleteCourse from '~/components/app/courses/DeleteCourse.vue';
import EditCourse from '~/components/app/courses/EditCourse.vue';
import Loader from '~/components/shared/Loader.vue';
import Pagination from '~/components/shared/Pagination.vue';

const modal = reactive({
  component: null,
  data: null,
})

const currentPage = ref(1)

watch(() => currentPage.value, () => {
  refresh()
})

async function fetchCourses() {
  return await getCourses({
    perPage: 12,
    page: currentPage.value,
    'filter[end_date_start]': useDayjs()().subtract(1, 'day').startOf('day').toISOString()})
}

const {pending, data, refresh} = useLazyAsyncData('courses', fetchCourses)

const createCourse = () => {
  modal.component = markRaw(CreateCourseComponent)
}

const updateCourse = (course) => {
  modal.component = markRaw(EditCourse)
  modal.data = course
}

const deleteCourse = (course) => {
  modal.component = markRaw(DeleteCourse)
  modal.data = course
}
</script>