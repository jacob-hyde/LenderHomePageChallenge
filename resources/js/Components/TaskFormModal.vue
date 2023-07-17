<script setup>
import { defineProps, onMounted, ref, reactive, defineEmits } from "vue";
import axios from 'axios';
import Modal from "./Modal.vue";

const allTasks = ref([]);

// Would rather use vuex so I dont have to make the same request in two places
onMounted(async () => {
    const {
        data: { data },
    } = await axios.get(route("task.index"));
    allTasks.value = data.map(task => {
        return {
            id: task.id,
            name: task.name,
        }
    });
});

const emit = defineEmits(["close"]);

const props = defineProps({
    task: Object,
    show: {
        type: Boolean,
        default: false,
    },
});

const taskForm = reactive({
    name: props.task ? props.task.name : "",
    description: props.task ? props.task.description : "",
    status: props.task ? props.task.status : "todo",
    parent_id: props.task ? props.task.parent_id : null,
});

const submitForm = async () => {
    if (!taskForm.parent_id) {
        taskForm.parent_id = null;
    }
    await axios.post(route("task.store"), taskForm); // Would add validation here and server error handling
    emit('close');
    window.location.reload(); // would rather update than reload here
}

</script>
<template>
    <Modal :show="show">
        <h2 class="text-lg leading-6 font-medium text-gray-900 flex justify-between">
            <span class="block">{{ task ? 'Edit Task' : 'Create Task' }}</span>
            <span class="block cursor-pointer" @click="$emit('close')"><fa icon="fa-solid fa-times" /></span>
        </h2>
        <div class="mt-2">
            <label for="name">Name:</label>
            <input type="text" v-model="taskForm.name" id="name" class="form-input rounded-md shadow-sm mt-1 block w-full" />
        </div>
        <div class="mt-2">
            <label for="description">Description:</label>
            <textarea type="text" v-model="taskForm.description" id="description" class="form-input rounded-md shadow-sm mt-1 block w-full"></textarea>
        </div>
        <div class="mt-2">
            <label for="status">Status:</label>
            <select name="status" id="status" v-model="taskForm.status" class="form-select rounded-md shadow-sm mt-1 block w-full">
                <option value="todo">To Do</option>
                <option value="in_progress">In Progress</option>
                <option value="done">Done</option>
            </select>
        </div>
        <div class="mt-2">
            <label for="parent_id">Parent Task:</label>
            <select name="parent_id" id="parent_id" v-model="taskForm.parent_id" class="form-select rounded-md shadow-sm mt-1 block w-full">
                <option value="">None</option>
                <option v-for="task in allTasks" :key="task.id" :value="task.id">{{ task.name }}</option>
            </select>
        </div>
        <div class="mt-2">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" @click="submitForm">Submit</button>
        </div>
    </Modal>
</template>
