<template>
  <CustomTable
    :headers="headers"
    :items="data"
    :loading="pending"
  >
    <template #columnTitle="{item}">
      <span>{{ _truncate(item?.title, {
        'length': 30,
        'omission': '...'
      }) }}</span>
    </template>
    <template #columnDates="{item}">
      <div>
        {{ useDayjs()(item?.start_date).format('DD-MM-YYYY') }}
        -
        {{ useDayjs()(item?.end_date).format('DD-MM-YYYY') }}
      </div>
    </template>
  </CustomTable>
</template>
<script setup lang="ts">
import CustomTable from '~/components/shared/CustomTable.vue';

const headers = [
  {value: 'id', label: 'ID'},
  {value: 'title', label: 'Curso'},
  {value: 'dates', label: 'Período do curso'},
  {value: 'videos_count', label: 'Número de vídeos'},
  {value: 'total_video_size', label: 'Tamanho ocupado (em MB)'},
]

defineProps(['data', 'meta', 'pending'])
</script>
