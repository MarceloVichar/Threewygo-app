<template>
  <Modal @close="$emit('close')">
    <div class="md:w-[700px] pt-6">
      <p class="text-center text-lg">
        Editar informações do curso
      </p>
      <CourseForm
        :sending="editing"
        :model-value="form"
        @cancel="$emit('close')"
        @submit="editCourse"
      />
    </div>
  </Modal>
</template>

<script setup lang="ts">
import {updateCourse} from '~/services/api/course/courseService';
import Modal from '~/components/shared/Modal.vue';
import CourseForm from '~/components/app/courses/CourseForm.vue';

const props = defineProps({
  data: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits(['close', 'refresh'])

const editing = ref(false)

const form = reactive({
  errors: [],
  data: {
    title: props.data?.title,
    description: props.data?.description,
    start_date: props.data?.start_date,
    end_date: props.data?.end_date,
    image: null,
    id: props.data?.id,
  },
})

const editCourse = (course: { data: { [x: string]: any; }; }) => {
  editing.value = true
  const formData = handleCourseData(course.data)

  updateCourse(course.data.id, formData)
    .then(() => {
      emit('close')
      emit('refresh')
    })
    .catch((error) => {
      form.errors = error.response.data.errors;
    })
    .finally(() => {
      editing.value = false
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
