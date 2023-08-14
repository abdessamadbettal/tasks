
// i want to be able to add a new task using tailwind and vue

<template>
  <body class="antialiased h-screen bg-slate-200 text-slate-700 mx-2 py-10">
    <div class="max-w-lg mx-auto   bg-white p-8 rounded-xl shadow shadow-slate-300">
        <div class="flex flex-row justify-between items-center">
        <form class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6" @submit.prevent="createTask">
          <div class="sm:col-span-4">
            <label
              for="username"
              class="block text-sm font-medium leading-6 text-gray-900"
              >title</label
            >
            <div class="mt-2">
              <div
                class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md"
              >

                <input
                  type="text"
                  name="title"
                  id="title"
                  autocomplete="title"
                  v-model="model.title"
                  class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                  placeholder="title of task"
                />
              </div>
            </div>
          </div>

          <div class="col-span-full">
            <label
              for="about"
              class="block text-sm font-medium leading-6 text-gray-900"
              >Description</label
            >
            <div class="mt-2">
              <textarea
                id="description"
                name="description"
                v-model="model.description"
                autocomplete="description"
                rows="3"
                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
              />
            </div>
            <p class="mt-3 text-sm leading-6 text-gray-600">
              Write a few sentences about your task.
            </p>
          </div>
          <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
          <TButton>
            <BookmarkIcon class="w-5 h-5 mr-2" />
            Save
          </TButton>
        </div>
        </form>
      </div>
    </div>
  </body>
</template>


<script setup >
import { useRoute, useRouter } from "vue-router";
import { computed, ref } from "vue";
import { BookmarkIcon } from '@heroicons/vue/24/solid'
import store from "../store";
import TButton from "../components/core/TButton.vue";

const router = useRouter();

const route = useRoute();

const taskLoading = computed(() => store.state.currentTask.loading);

let model = ref({
    title: "",
    description: "",
    });

    // create task
    const createTask = async () => {
        await store.dispatch("createTask", model.value);
        router.push({ name: "Tasks" });
    };

</script>




