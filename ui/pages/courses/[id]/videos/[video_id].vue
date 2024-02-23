<template>
  <div class="">
    <div class="flex flex-col sm:flex-row justify-between gap-2 sm:items-center my-4 w-full">
      <h2 class="font-bold text-2xl text-ellipsis overflow-hidden h-8 text-center" :title="data?.title">
        {{ data?.title }}
      </h2>
      <div class="flex gap-2 justify-between">
        <button class="btn w-full sm:w-32" @click="navigateTo(`/courses/${route.params.id}` )">
          Voltar
        </button>
      </div>
    </div>
    <div class="flex flex-col lg:flex-row gap-2">
      <div class="w-full p-2 border rounded ">
        <div class="w-full aspect-video">
          <VideoPlayer v-if="dataIsReady" :options="videoOptions" />
        </div>
        <div class="mt-2">
          <h1 class="text-2xl font-bold break-all">
            {{ currentVideo.title }}
          </h1>
          <p class="text-lg">
            {{ currentVideo.description }}
          </p>
        </div>
      </div>
      <div class="lg:w-[500px] rounded border p-2 ">
        <p class="text-center static">
          Vídeos do curso
        </p>
        <div class="lg:h-[500px] overflow-y-auto">
          <div v-for="video in data?.videos" :key="video?.id">
            <div
              class="flex w-full gap-2 py-2 border-b-2 cursor-pointer"
              :title="video?.title"
              :class="{'bg-base-200': video.id?.toString() === route.params.video_id}"
              @click="changeVideo(video.id)"
            >
              <div class="w-32 h-20">
                <img
                  v-if="video?.image_url"
                  :src="video?.image_url"
                  alt="imagem do vídeo"
                  class="object-cover object-center w-full h-full"
                >
                <div
                  v-else
                  class="object-cover object-center w-full h-full"
                />
              </div>
              <div style="width: calc(100% - 140px)" class="flex items-center">
                <p class="text-ellipsis h-12 break-all overflow-hidden">
                  {{ video?.title }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import VideoPlayer from '~/components/shared/VideoPlayer.vue';

const courseStore = useCourses()

const dataIsReady = ref(false)

const videoOptions = reactive({
  autoplay: false,
  controls: true,
  disablePictureInPicture: true,
  poster: 'http://localhost/storage/25/video-image-5.png',
  sources: [
    {
      src: 'http://localhost/storage/26/video-5.mp4',
      type: 'video/mp4',
    },
  ],
})

const route = useRoute()

const currentVideo = ref({} as any)

watch(() => currentVideo.value, (video) => {
  if (video) {
    videoOptions.sources = [
      {
        src: video.video_url,
        type: 'video/mp4',
      },
    ]
    videoOptions.poster = video.image_url
  }
  dataIsReady.value = true
})

async function fetchVideos() {
  await courseStore.ensureCourse(route.params?.id?.toString()).then(() => {
    currentVideo.value = getVideo()
  })
  return courseStore.currentCourse
}

const {data} = useLazyAsyncData('course', fetchVideos)

const getVideo = () => {
  return  courseStore.getVideoById(route.params?.video_id?.toString())
}

const changeVideo = (id: string|number) => {
  if (id !== route.params?.video_id) {
    navigateTo(`/courses/${route.params?.id}/videos/${id}`)
  }
}

</script>
