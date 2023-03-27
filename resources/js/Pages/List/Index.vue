<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";


const props = defineProps({
    tasks: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    name: "",
});

const createTask = () => {
    form.post('/tasks/', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            taskNameInput.value.focus();
        },
    });
};

const toggleDone = (id) => {
    axios.put('/tasks/' + id, {
        preserveScroll: true
    })

};

const deleteTask = (id) => {
    axios.delete('/tasks/' + id, {
        preserveScroll: true,
        onSuccess: () => {
            // delete from tasks the element that contains id equals to id
            const index = tasks.findIndex((task) => task.id === id);
            tasks.splice(index, 1);
        },
    })

};

</script>

<template>
    <form @submit.prevent="createTask">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2 class="text-xl font-bold">Tasks ({{ tasks.length }})</h2>
                <div
                    class="bg-white dark:bg-gray-200 overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="flex">
                        <div class="flex-1 text-gray-100 dark:text-gray-900">
                            <input
                                id="name"
                                ref="taskNameInput"
                                v-model="form.name"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="New Task"
                                autocomplete="task"
                            />
                        </div>
                        <button
                            type="submit"
                            class="flex-none text-white px-4 bg-gray-500 hover:bg-blue-700"
                        >
                            +Add
                        </button>
                    </div>
                </div>
                <div class="mt-5">
                    <ul class="px-4 mt-5">
                        <li class="pb-5" v-for="task in tasks" :key="task.id">
                            <div class="flex">
                                <div :class="{'bg-green-200': task.status}" class="flex-1 ">{{ task.name }}</div>
                                <div class="flex-none">
                                    <input type="checkbox"
                                        v-model="task.status"
                                        :id="task.id"
                                        class="my-2 mx-2"
                                        @click="toggleDone(task.id)"
                                    >
                                    <button
                                        @click="deleteTask(task.id)"
                                        class="text-white px-4 bg-red-500 hover:bg-red-700 font-extrabold"
                                    >
                                        X
                                    </button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </form>
</template>
