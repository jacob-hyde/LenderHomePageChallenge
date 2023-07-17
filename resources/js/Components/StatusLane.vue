<script setup>
import { defineProps, ref, defineEmits } from "vue";
import draggable from "vuedraggable";
import Task from "./Task.vue";

const props = defineProps({
    name: String,
    tasks: Array,
    lane: String,
});

const emit = defineEmits(["update:task"]);

const tasksList = ref(props.tasks);
const drag = ref(false);

const dragEnded = (evt) => {
    const id = evt.item.id;
    const newStatus = evt.to.id;
    drag.value = false;
    emit("update:task", { id, newStatus });
}
</script>
<template>
    <div class="lane w-1/3 bg-white overflow-hidden shadow-sm sm:rounded-lg mx-4">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ name }}
            </h2>
        </div>
        <div class="py-6 bg-white">
            <draggable
                v-model="tasksList"
                group="statusLane"
                @start="drag = true"
                @end="dragEnded"
                item-key="id"
                :id="lane"
            >
                <template #item="{ element }">
                    <Task :task="element" :id="element.id" />
                </template>
            </draggable>
        </div>
    </div>
</template>
<!-- <style scoped>
.lane {
    min-width: 45%;
}
</style> -->
