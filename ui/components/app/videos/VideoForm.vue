<template>
  <Form v-slot="{ meta }" class="grid p-1 w-full" @submit="onSubmit">
    <Field
      v-slot="{ field, errors }"
      v-model="mutableForm.data.title"
      name="title"
      rules="required|min:2|max:100"
    >
      <CustomInput
        v-bind="field"
        v-model="field.value"
        required
        type="text"
        placeholder="Título do vídeo"
        label="Título"
        :errors="useErrorBag(errors, mutableForm.errors, 'title')"
      />
    </Field>
    <Field
      v-slot="{ field, errors }"
      v-model="mutableForm.data.description"
      name="description"
      rules="required|min:2|max:254"
    >
      <CustomInput
        v-bind="field"
        v-model="field.value"
        required
        type="text"
        placeholder="Descrição do vídeo"
        label="Descrição"
        :errors="useErrorBag(errors, mutableForm.errors, 'description')"
      />
    </Field>
    <div class="flex flex-col">
      <span
        class="text-sm mb-1 ml-2"
      >
        Imagem de thumbnail (1kb até 1mb, formato PNG)
      </span>
      <input
        type="file"
        accept="image/png"
        class="file-input w-full"
        @change="validateImage"
      >
    </div>
    <div v-if="action === 'create'" class="flex flex-col mt-6">
      <span
        class="text-sm mb-1 ml-2"
      >
        Vídeo (1kb até 40mb, formato MP4)
      </span>
      <input
        type="file"
        accept="video/mp4"
        class="file-input w-full"
        @change="validateVideo"
      >
    </div>
    <div class="flex justify-between gap-2 mt-4">
      <button
        class="btn"
        type="button"
        :disabled="sending"
        @click="$emit('cancel')"
      >
        Cancelar
      </button>
      <button class="btn btn-primary" type="submit" :disabled="!meta.valid || sending || !videoIsValidated">
        Salvar
      </button>
    </div>
  </Form>
</template>

<script setup lang="ts">
import {Field, Form} from 'vee-validate';
import CustomInput from '~/components/shared/form-components/CustomInput.vue';

const props = defineProps({
  modelValue: {
    type: Object,
    required: true,
  },
  sending: {
    type: Boolean,
    default: false,
  },
  action: {
    type: String,
    default: 'create',
  },
})

const emit = defineEmits(['submit', 'cancel'])

const form = _cloneDeep(props.modelValue)
const mutableForm = reactive(form)

const videoIsValidated = computed(() => {
  return props.action === 'create' ? !!mutableForm.data.video : true
})

watch(
  () => props.modelValue,
  (newValue) => {
    Object.assign(mutableForm, newValue)
  },
  { immediate: true, deep: true },
)

const onSubmit = () => {
  if (props.sending) return
  emit('submit', mutableForm)
}

const validateImage = (event: { target: { files: any[]; value: string; }; }) => {
  const file = event.target.files[0];
  if (file.type !== 'image/png') {
    alert('Por favor, carregue apenas imagens PNG.');
    event.target.value = '';
    mutableForm.data.image = null
  } else {
    mutableForm.data.image = file;
  }
}

const validateVideo = (event: { target: { files: any[]; value: string; }; }) => {
  const file = event.target.files[0];
  if (file.type !== 'video/mp4') {
    alert('Por favor, carregue apenas vídeos MP4.');
    event.target.value = '';
    mutableForm.data.video = null
  } else {
    mutableForm.data.video = file;
  }
}
</script>
