import {defineRule, configure, Form, Field} from 'vee-validate';
import {required, min, max} from '@vee-validate/rules';
import {localize, setLocale} from '@vee-validate/i18n'
import pt_BR from '@vee-validate/i18n/dist/locale/pt_BR.json';

export default defineNuxtPlugin((nuxtApp) => {
  nuxtApp.vueApp.component('VeeForm', Form)
  nuxtApp.vueApp.component('VeeField', Field)

  defineRule('required', required);
  defineRule('min', min);
  defineRule('max', max);

  defineRule('minDate', (value = '', [target] = '') => {
    if (!value || !target)
      return true;

    const dateFrom = target.replace(/(\d{2})\/(\d{2})\/(\d{4})/, '$2/$1/$3');
    const dateTo = value.replace(/(\d{2})\/(\d{2})\/(\d{4})/, '$2/$1/$3');

    if (new Date(dateTo) > new Date(dateFrom)) {
      return true;
    }
    return 'A data está abaixo do limite permitido.';
  });
});

defineRule('maxDate', (value = '', [target] = '') => {
  if (!value || !target)
    return true;

  const dateFrom = target.replace(/(\d{2})\/(\d{2})\/(\d{4})/, '$2/$1/$3');
  const dateTo = value.replace(/(\d{2})\/(\d{2})\/(\d{4})/, '$2/$1/$3');

  if (new Date(dateTo) < new Date(dateFrom)) {
    return true;
  }
  return 'A data está acima do limite permitido.';
})

localize({pt_BR});

configure({
  validateOnBlur: true,
  validateOnChange: true,
  validateOnInput: true,
  validateOnModelUpdate: true,
  generateMessage: localize('pt_BR'),
});

setLocale('pt_BR')
