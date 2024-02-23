<template>
  <Modal @close="$emit('close')">
    <div class="md:w-[700px] pt-6">
      <p class="text-center text-lg">
        Adicionar curso
      </p>
      <CourseForm
        :sending="creating"
        :model-value="form"
        @cancel="$emit('close')"
        @submit="createCourse"
      />
    </div>
  </Modal>
</template>

<script setup lang="ts">
import {createCourse as createCourseForm} from '~/services/api/course/courseService';
import Modal from '~/components/shared/Modal.vue';
import CourseForm from '~/components/app/courses/CourseForm.vue';

const emit = defineEmits(['close', 'refresh'])

const creating = ref(false)

const form = reactive({
  errors: [],
  data: {
    title: '',
    description: '',
    start_date: '',
    end_date: '',
    image: null,
  },
})

const createCourse = (course: { data: { [x: string]: any; }; }) => {
  creating.value = true
  const formData = handleCourseData(course.data)

  createCourseForm(formData)
    .then(() => {
      emit('close')
      emit('refresh')
      useNotify('success', 'Curso criado com sucesso')
    })
    .catch((error) => {
      form.errors = error.response.data.errors;
      useNotify('error', 'Não foi possível criar o curso')
    })
    .finally(() => {
      creating.value = false
    })
}

const handleCourseData = (data: any) => {
  if (data.start_date) {
    data.start_date = useDayjs()(data.start_date).format('YYYY-MM-DD')
  }
  if (data.end_date) {
    data.end_date = useDayjs()(data.end_date).format('YYYY-MM-DD')
  }
  const formData = new FormData();

  for (const key in data) {
    if (data[key] !== null) {
      formData.append(key, data[key]);
    }
  }

  return formData
}
</script>
