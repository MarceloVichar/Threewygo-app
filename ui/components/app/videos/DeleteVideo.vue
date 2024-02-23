<template>
  <ConfirmationModal
    title="Excuir vídeo"
    message="Deseja realmente excluir o vídeo?"
    :loading="deleting"
    @confirm="removeVideo"
    @cancel="$emit('close')"
    @close="$emit('close')"
  />
</template>

<script setup lang="ts">
import ConfirmationModal from '~/components/shared/ConfirmationModal.vue';
import {deleteVideo} from '~/services/api/video/videoService';

const props = defineProps({
  data: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits(['close', 'refresh'])

const deleting = ref(false)

const removeVideo = () => {
  deleting.value = true
  deleteVideo(props.data?.id)
    .then(() => {
      deleting.value = false
      emit('close')
      emit('refresh')
      useNotify('success', 'Vídeo excluído com sucesso')
    })
    .catch(() => {
      deleting.value = false
      useNotify('error', 'Erro ao excluir vídeo')
    })
}
</script>
