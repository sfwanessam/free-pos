


<script setup>
import { ref, computed } from 'vue';
import * as Heroicons from '@heroicons/vue/24/outline'; // or use @heroicons/vue/24/solid for solid icons

const props = defineProps({
  name: {
    type: String,
    required: true,
  },
  size: {
    type: String,
    default: 'size-6', // Default size to 'medium'
    
  },
  colorClass:{
    type: String,
  }
});

const iconComponent = computed(() => {
  return Heroicons[props.name] || null;
});

const getClasses = () =>{
  return props.size + " " + props.colorClass;
}


</script>

<template>
  <component
    :is="iconComponent"
    aria-hidden="true"
    :class="getClasses()"
    v-if="iconComponent"
  />
  <span v-else>Icon not found</span>
</template>
