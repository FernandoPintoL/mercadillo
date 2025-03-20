<script setup>
const props = defineProps({
    model_path: {
        type: String,
        default: '',
    },
    isCreate: {
        type: Boolean,
        default: true, // Valor por defecto puede ser true o false
    },
    id_model: {
        type: String,
        default: '' // Valor por defecto puede ser 0
    },
})
</script>

<template>
    <h5 v-if="props.isCreate" class="inline-flex items-center mb-6 text-lg font-semibold text-gray-500 uppercase dark:text-gray-400">
        Crear {{ props.model_path }}
    </h5>
    <h5 v-else class="inline-flex items-center mb-6 text-lg font-semibold text-gray-500 uppercase dark:text-gray-400">
        Editar {{ props.model_path }} | ID: {{ props.id_model }}
    </h5>
</template>
