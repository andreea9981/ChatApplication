<template>
    <template v-if="isLoading">
        Loading...
    </template>
    <div v-else>
        <AppLayout title="Dashboard">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        <ChatRoomSelection
                            v-if="currentRoom.id"
                            :rooms="chatRooms"
                            :currentRoom="currentRoom"
                            @roomchanged="setRoom"
                        ></ChatRoomSelection>
                    </h2>
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <MessageContainer :messages="messages" />
                        <InputMessage
                            :key="currentRoom.id"
                            v-if="currentRoom.id"
                            :room="currentRoom"
                            @messagesent="getMessages"
                        />
                    </div>
                </div>
            </div>
        </AppLayout>
    </div>
</template>


<script setup lang="ts">
import AppLayout from '../../Layouts/AppLayout.vue';
import MessageContainer from './messageContainer.vue';
import InputMessage from './inputMessage.vue';
import ChatRoomSelection from './chatRoomSelection.vue';
import axios from "axios";

import { ref, onMounted, watch } from "vue";

const chatRooms = ref([]);
const currentRoom = ref({});
const messages = ref([]);

const setRoom = async (room) => {
    currentRoom.value = room;
    await getMessages();
};

const getMessages = async () => {
    try {
        const response = await axios.get(`/chat/room/${currentRoom.value.id}/messages`);
        messages.value = response.data;
    } catch (error) {
        console.log(error);
    }
};

const getRooms = async () => {
    try {
        const response = await axios.get('/chat/rooms');
        chatRooms.value = response.data;
        await setRoom(response.data[0]);
    } catch (error) {
        console.error(error);
    }
};

const connect = () => {
    if (currentRoom.value.id) {
        getMessages();
        window.Echo.private("chat." + currentRoom.value.id)
            .listen('.message.new', e => {
                getMessages();
            });
    }
}

const disconnect = (room) => {
    window.Echo.leave("chat." + room.id);
}

onMounted(() => {
    getRooms();
});

watch(currentRoom, (newValue, oldValue) => {
    if (oldValue.id) {
        disconnect(oldValue);
    }
    connect();
});
</script>
