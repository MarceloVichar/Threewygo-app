<template>
  <div class="overflow-x-auto rounded">
    <table class="w-full border-none lg:border border-accent-content">
      <thead class="hidden lg:table-header-group">
        <slot name="header" :headers="headers">
          <tr class="border-t border-x-0 border-b-2 border-accent-content shadow bg-base-100">
            <th
              v-for="header in headers"
              :key="header.label"
              class="!rounded-b-none !static  capitalize text-sm p-3 text-start"
            >
              {{ header.label }}
            </th>
          </tr>
        </slot>
      </thead>

      <tbody class="grid grid-cols-1 md:grid-cols-2 md:gap-5 lg:table-row-group">
        <slot name="body" :items="items">
          <tr v-if="loading" class="col-span-2">
            <td colspan="100%" class="block lg:table-cell">
              <div class="flex justify-center my-12">
                <Loader class="mx-auto align-top" />
              </div>
            </td>
          </tr>
          <tr
            v-for="item in items"
            v-else
            :key="item.id || JSON.stringify(item)"
            class="mb-5 md:mb-0 bg-base-100 bg-opacity-60 hover:bg-opacity-100 border-b last-border-b-0 border-accent-content text-sm font-normal  block  lg:table-row relative"
          >
            <td
              v-for="header in headers"
              :key="header.value"
              class="!whitespace-normal bg-transparent px-3 py-2 lg:py-4 flex justify-between items-center gap-1 text-right lg:text-left lg:table-cell border-b lg:border-b-0 box-content h-5"
            >
              <span class="inline-block lg:hidden font-bold">{{ header.label }}</span>
              <div class="break-all lg:break-normal">
                <slot :name="columnSlotName(header.value)" :item="item">
                  {{ getItemAttr(item, header.value) }}
                </slot>
              </div>
            </td>
          </tr>
          <tr v-if="isEmpty(items)" class="col-span-2">
            <slot name="emptyBody">
              <td class="block lg:table-cell text-lg text-gray-600 text-center !py-12 font-bold" colspan="100%">
                <label>Nenhum item encontrado</label>
              </td>
            </slot>
          </tr>
        </slot>
      </tbody>
    </table>
  </div>
</template>

<script>
import Loader from '~/components/shared/Loader.vue';

export default {
  name: 'CustomTable',
  components: {Loader},
  props: {
    headers: {
      type: Array,
      required: true,
    },
    items: {
      type: Array,
      default() {
        return []
      },
    },
    loading: {
      type: Boolean,
      default: false,
    },
  },

  methods: {
    isEmpty: _isEmpty,
    getItemAttr(item, attr) {
      return _get(item, attr, '-')
    },

    columnSlotName(headerValue) {
      return 'column' + _upperFirst(_camelCase(headerValue))
    },
  },
}
</script>
