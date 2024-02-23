<template>
  <Modal @close="$emit('close')">
    <div class="md:w-[700px] pt-6">
      <p class="text-center text-lg">
        Editar informações do vídeo
      </p>
      <VideoForm
        :sending="editing"
        :model-value="form"
        action="edit"
        @cancel="$emit('close')"
        @submit="editVideo"
      />
    </div>
  </Modal>
</template>

<script setup lang="ts">
import {updateVideo} from '~/services/api/video/videoService';
import Modal from '~/components/shared/Modal.vue';
import VideoForm from '~/components/app/videos/VideoForm.vue';
import {GetVideoData} from '~/services/api/video/GetVideoData';

const props = defineProps({
  data: {
    type: GetVideoData,
    required: true,
  },
})

const emit = defineEmits(['close', 'refresh'])

const route = useRoute()

const editing = ref(false)

const form = reactive({
  errors: [],
  data: {
    course_id: route.params?.id,
    title: props.data?.title,
    description: props.data?.description,
    image: null,
    video: null,
    id: props.data?.id,
  },
})

const editVideo = (video: { data: { [x: string]: any; }; }) => {
  editing.value = true
  const formData = handleVideoData(video.data)

  updateVideo(video.data.id, formData)
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

const handleVideoData = (data: any) => {
  const formData = new FormData();

  for (const key in data) {
    if (data[key] !== null) {
      formData.append(key, data[key]);
    }
  }

  formData.append('_METHOD', 'PUT')

  return formData
}
</script>
