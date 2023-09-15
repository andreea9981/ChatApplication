<template>
   {{message.user.name}} : {{message.message}}
</template>
<script setup lang="ts">
import {defineProps} from "vue";

const { message } = defineProps({
    message: Object
});
</script>
