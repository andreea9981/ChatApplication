<template>
    <div class="grid grid-cols-2">
        <div class="font-bold text-xl">
            {{ selected.name }} Chat
        </div>
        <div>
            <select v-model="selected" @change="roomChanged(selected)" class="float-right">
                <option v-for="(room, index) in rooms" :key="index" :value="room">{{ room.name }}</option>
            </select>
        </div>
    </div>
</template>
<script setup lang="ts">
import { defineProps, defineEmits } from "vue";
import { ref } from "vue";

const { rooms, currentRoom } = defineProps({
    rooms: Array,
    currentRoom: Object,
});

const emits = defineEmits(['roomchanged']);

const selected = ref(currentRoom);

const roomChanged = (room) => {
    emits('roomchanged', room);
};
</script>
