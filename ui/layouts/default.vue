<template>
  <div>
    <div class="z-10 h-16 px-2 border-b-2 border-primary bg-base-100 shadow fixed w-full flex justify-between items-center">
      <div @click="navigateTo('/')">
        <img src="/logo.png" class="h-6 object-cover" alt="logo">
      </div>
      <div>
        <!--        <button class="btn btn-primary btn-circle" title="Administrar cursos">-->
        <!--          c-->
        <!--        </button>-->
      </div>
    </div>
    <div class="p-2 pt-16 flex justify-center">
      <div class="max-w-7xl w-full">
        <slot />
      </div>
    </div>
  </div>
</template>
