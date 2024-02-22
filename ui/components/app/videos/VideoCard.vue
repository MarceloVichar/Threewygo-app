<template>
  <div class="card w-full bg-base-100 shadow-lg">
    <figure class="h-44 border-b shadow">
      <img
        v-if="item?.image_url"
        :src="item?.image_url"
        alt="imagem do vídeo"
        class="object-cover object-center"
      >
      <img
        v-else
        src="/logo.png"
        class="h-6 opacity-60"
        alt="Imagem do vídeo"
      >
    </figure>
    <div class="card-body p-2">
      <div class="flex gap-2 justify-end">
        <Icon name="material-symbols:edit" class="text-warning cursor-pointer" @click="$emit('edit', item)" />
        <Icon name="material-symbols:delete" class="text-error cursor-pointer" @click="$emit('delete', item)" />
      </div>
      <p class="text-ellipsis h-20 text-lg break-all overflow-hidden" :title="item?.title">
        {{ item?.title }}
      </p>
      <div class="w-full flex">
        <button
          class="btn btn-primary grow"
          :disabled="!item?.video_url"
          @click="$emit('show', item)"
        >
          Assistir
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import {GetVideoData} from '~/services/api/video/GetVideoData';

defineProps({
  item: {
    type: GetVideoData,
    required: true,
  },
})

defineEmits(['edit', 'show', 'delete'])
</script>
