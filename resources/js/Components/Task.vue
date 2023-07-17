<script setup>
import { defineProps, ref } from "vue";
import TaskFormModal from "./TaskFormModal.vue";

const props = defineProps({
    task: Object,
});

const editModalOpen = ref(false);
const description = ref(props.task.description)

if (props.task.description.length > 10) {
    description.value = props.task.description.substring(0, 10) + "...";
}

const deleteTask = async () => {
    await axios.delete(route("task.destroy", props.task.id));
    window.location.reload();
};
</script>

<template>
    <div
        class="task bg-cyan-50 overflow-hidden shadow-sm sm:rounded-lg mx-4 p-2 mt-4"
    >
        <div class="border-b border-gray-200 py-2">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex justify-between">
                <span class="d-block">{{ task.name }}</span>
                <div>
                    <span @click="editModalOpen = true" class="cursor-pointer"><fa icon="fa-solid fa-pencil" /></span>
                    &nbsp;
                    <span @click="deleteTask" class="cursor-pointer"><fa icon="fa-solid fa-trash" /></span>
                </div>
            </h2>
        </div>
        <div class="py-6">
            <p class="text-gray-700 text-base">
                {{ description }}
            </p>
        </div>
        <teleport to="#modal">
            <TaskFormModal v-if="editModalOpen" :show="editModalOpen" :task="task" @close="editModalOpen = false" />
        </teleport>
    </div>
</template>
