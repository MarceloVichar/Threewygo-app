<template>
  <div class="w-full">
    <div class="flex flex-col sm:flex-row justify-between gap-2 items-center my-4 w-full">
      <h2 class="text-center font-bold text-2xl ">
        Ocupação de espaço no disco por curso
      </h2>
      <div class="flex gap-2 justify-between">
        <button class="btn" @click="navigateTo('/')">
          Voltar
        </button>
      </div>
    </div>
    <div v-if="pending" class="flex justify-center my-8">
      <Loader />
    </div>
    <div v-else>
      <CoursesTable :data="data" :pending="pending" />
    </div>
  </div>
</template>

<script setup lang="ts">
import Loader from '~/components/shared/Loader.vue';
import {getCourseMetrics} from '~/services/api/course/courseService';
import CoursesTable from '~/components/app/metrics/CoursesTable.vue';

async function fetchMetrics() {
  return await getCourseMetrics()
    .catch(() => {
      useNotify('error', 'Erro ao buscar métricas')
    })
}

const {pending, data} = useAsyncData('metrics', fetchMetrics)
</script>
