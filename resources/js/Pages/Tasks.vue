<script setup>
import { reactive, onMounted, ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import axios from "axios";
import StatusLane from "@/Components/StatusLane.vue";
import TaskFormModal from "@/Components/TaskFormModal.vue";

const taskBoard = reactive({
    todo: {
        name: "To Do",
        tasks: [],
    },
    in_progress: {
        name: "In Progress",
        tasks: [],
    },
    done: {
        name: "Done",
        tasks: [],
    },
});

const showTaskFormModal = ref(false);

onMounted(async () => {
    const {
        data: { data },
    } = await axios.get(route("task.index"));

    for (const task of data) {
        taskBoard[task.status].tasks.push(task);
    }
});

const statusUpdated = async ({ id, newStatus }) => {
    const {
        data: { data },
    } = await axios.put(route("task.update", id), { status: newStatus });

    const task = taskBoard[data.status].tasks.find(
        (task) => task.id === data.id
    );
    task.status = data.status;
};
</script>

<template>
    <Head title="Tasks" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tasks
            </h2>
        </template>

        <div class="text-center mt-4">
            <button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                @click="showTaskFormModal = true"
            >
                Create Task
            </button>
        </div>

        <div class="p-6 flex flex-row justify-between overflow-y-auto">
            <StatusLane
                v-for="(lane, laneName) in taskBoard"
                :key="lane.name"
                :name="lane.name"
                :tasks="lane.tasks"
                :lane="laneName"
                @update:task="statusUpdated"
            />
        </div>

        <teleport to="#modal">
            <TaskFormModal
                v-if="showTaskFormModal"
                :show="showTaskFormModal"
                @close="showTaskFormModal = false"
            />
        </teleport>
    </AuthenticatedLayout>
</template>
