<template>
  <div class="w-full">
    <div class="flex flex-col sm:flex-row justify-between gap-2 sm:items-center my-4 w-full">
      <h2 class="font-bold text-2xl text-ellipsis overflow-hidden h-8 text-center" :title="data?.title">
        {{ data?.title }}
      </h2>
      <div class="flex gap-2 justify-between">
        <button class="btn  sm:w-32" @click="navigateTo('/')">
          Voltar
        </button>

        <button class="btn btn-primary w-auto" @click="createVideo">
          Adicionar vídeo
        </button>
      </div>
    </div>
    <div v-if="pending" class="flex justify-center my-8">
      <Loader />
    </div>
    <div v-else>
      <div v-if="!data?.videos?.length" class="text-center my-12">
        Nenhum vídeo disponível
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 w-full">
        <VideoCard
          v-for="video in data?.videos"
          :key="video?.id"
          :item="video"
          @edit="updateVideo"
          @delete="deleteVideo"
          @show="navigateTo(`/courses/${$route.params?.id}/videos/${$event?.id}`)"
        />
      </div>
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
import VideoCard from '~/components/app/videos/VideoCard.vue';
import CreateVideoComponent from '~/components/app/videos/CreateVideo.vue';
import DeleteVideo from '~/components/app/videos/DeleteVideo.vue';
import EditVideo from '~/components/app/videos/EditVideo.vue';
import Loader from '~/components/shared/Loader.vue';

const route = useRoute()
const courseStore = useCourses()

const modal = reactive({
  component: null,
  data: null,
})

async function fetchVideos() {
  await courseStore.getCourse(route.params?.id?.toString())
  return courseStore.currentCourse
}

const {pending, data, refresh} = useLazyAsyncData('course', fetchVideos)

const createVideo = () => {
  modal.component = markRaw(CreateVideoComponent)
}

const updateVideo = (video) => {
  modal.component = markRaw(EditVideo)
  modal.data = video
}

const deleteVideo = (video) => {
  modal.component = markRaw(DeleteVideo)
  modal.data = video
}
</script>
