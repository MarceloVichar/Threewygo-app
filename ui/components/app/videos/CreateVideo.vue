<template>
  <Modal @close="$emit('close')">
    <div class="md:w-[700px] pt-6">
      <p class="text-center text-lg">
        Adicionar vídeo
      </p>
      <VideoForm
        :sending="creating"
        :model-value="form"
        action="create"
        @cancel="$emit('close')"
        @submit="createVideo"
      />
    </div>
  </Modal>
</template>

<script setup lang="ts">
import {createVideo as createVideoForm} from '~/services/api/video/videoService';
import Modal from '~/components/shared/Modal.vue';
import VideoForm from '~/components/app/videos/VideoForm.vue';

const emit = defineEmits(['close', 'refresh'])

const creating = ref(false)

const route = useRoute()

const form = reactive({
  errors: [],
  data: {
    title: '',
    description: '',
    image: null,
    video: null,
    course_id: route.params?.id,
  },
})

const createVideo = (video: { data: { [x: string]: any; }; }) => {
  creating.value = true
  const formData = handleVideoData(video.data)

  createVideoForm(formData)
    .then(() => {
      emit('close')
      emit('refresh')
    })
    .catch((error) => {
      form.errors = error.response.data.errors;
    })
    .finally(() => {
      creating.value = false
    })
}

const handleVideoData = (data: any) => {
  const formData = new FormData();

  for (const key in data) {
    if (data[key] !== null) {
      formData.append(key, data[key]);
    }
  }

  return formData
}
</script>
