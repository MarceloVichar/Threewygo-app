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
        placeholder="Título do curso"
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
        placeholder="Descrição do curso"
        label="Descrição"
        :errors="useErrorBag(errors, mutableForm.errors, 'description')"
      />
    </Field>
    <Field
      v-slot="{ field, errors }"
      v-model="mutableForm.data.start_date"
      name="start_date"
      rules="required"
    >
      <CustomDatePicker
        v-bind="field"
        v-model="field.value"
        required
        :min-date="new Date()"
        placeholder="Início do curso"
        label="Início do curso"
        :errors="useErrorBag(errors, mutableForm.errors, 'start_date')"
      />
    </Field>
    <Field
      v-slot="{ field, errors }"
      v-model="mutableForm.data.end_date"
      name="end_date"
      rules="required"
    >
      <CustomDatePicker
        v-bind="field"
        v-model="field.value"
        required
        :min-date="mutableForm.data?.start_date"
        placeholder="Fim do curso"
        label="Fim do curso"
        :errors="useErrorBag(errors, mutableForm.errors, 'end_date')"
      />
    </Field>
    <div class="flex flex-col">
      <span
        class="text-sm mb-1 ml-2"
      >
        Imagem do curso (1kb até 1mb, formato PNG)
      </span>
      <input
        type="file"
        accept="image/png"
        class="file-input w-full"
        @change="validateFile"
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
      <button class="btn btn-primary" type="submit" :disabled="!meta.valid || sending">
        Salvar
      </button>
    </div>
  </Form>
</template>

<script setup lang="ts">
import {Field, Form} from 'vee-validate';
import CustomInput from '~/components/shared/form-components/CustomInput.vue';
import CustomDatePicker from '~/components/shared/form-components/CustomDatePicker.vue';

const props = defineProps({
  modelValue: {
    type: Object,
    required: true,
  },
  sending: {
    type: Boolean,
    default: false,
  },
})

const emit = defineEmits(['submit', 'cancel'])

const form = _cloneDeep(props.modelValue)
const mutableForm = reactive(form)

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

const validateFile = (event: { target: { files: any[]; value: string; }; }) => {
  const file = event.target.files[0];
  if (file.type !== 'image/png') {
    alert('Por favor, carregue apenas imagens PNG.');
    event.target.value = '';
    mutableForm.data.image = null
  } else {
    mutableForm.data.image = file;
  }
}
</script>
