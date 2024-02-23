<template>
  <ConfirmationModal
    title="Excuir curso"
    message="Deseja realmente excluir o curso e todos os seus vídeos?"
    :loading="deleting"
    @confirm="removeCourse"
    @cancel="$emit('close')"
    @close="$emit('close')"
  />
</template>

<script setup lang="ts">
import ConfirmationModal from '~/components/shared/ConfirmationModal.vue';
import {deleteCourse} from '~/services/api/course/courseService';

const props = defineProps({
  data: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits(['close', 'refresh'])

const deleting = ref(false)

const removeCourse = () => {
  deleting.value = true
  deleteCourse(props.data?.id)
    .then(() => {
      deleting.value = false
      emit('close')
      emit('refresh')
      useNotify('success', 'Curso excluído com sucesso')
    })
    .catch(() => {
      deleting.value = false
      useNotify('error', 'Erro ao excluir curso')
    })
}
</script>
