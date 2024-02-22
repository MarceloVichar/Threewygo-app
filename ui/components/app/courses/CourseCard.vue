<template>
  <div class="card w-full bg-base-100 shadow-lg">
    <figure class="h-44 border-b shadow">
      <img
        v-if="item.image_url"
        :src="item.image_url"
        alt="imagem do curso"
        class="object-cover object-center"
      >
      <img
        v-else
        src="/logo.png"
        class="h-6 opacity-60"
        alt="Imagem do curso"
      >
    </figure>
    <div class="card-body p-2">
      <div class="flex gap-1">
        <h2 class="text-ellipsis overflow-hidden h-8 text-xl w-full" :title="item.title">
          {{ item.title }}
        </h2>
        <div class="flex gap-2">
          <Icon name="material-symbols:edit" class="text-warning cursor-pointer" @click="$emit('edit', item)" />
          <Icon name="material-symbols:delete" class="text-error cursor-pointer" @click="$emit('delete', item)" />
        </div>
      </div>
      <p class="text-ellipsis overflow-hidden h-20 text-sm" :title="item.description">
        {{ item.description }}
      </p>
      <div class="w-full flex">
        <button class="btn btn-primary grow" @click="$emit('show', item)">
          Assistir
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import {GetCourseData} from '~/services/api/course/GetCourseData';

defineProps({
  item: {
    type: GetCourseData,
    required: true,
  },
})

defineEmits(['edit', 'show', 'delete'])
</script>
