<template>
    <div class="h-96 w-full">
        <div class="h-full p-2 flex flex-col-reverse overflow-scroll">
            <div v-for="(message, index) in messages" :key="index">
                <message-item :message="message"></message-item>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import {defineProps} from "vue/dist/vue";
import MessageItem from "./messageItem.vue"
const { messages } = defineProps({
    messages: Object

});

</script>
