<script setup>
import { ref, computed, watch } from "vue";
import { Head, useForm, Link } from "@inertiajs/inertia-vue3";
import Container from "../components/Container.vue";
import NavBar from "../components/NavBar.vue";
import Connector from "../components/Connector.vue";
import axios from "axios";
import { Inertia } from "@inertiajs/inertia";

// debounce javascript function
const debounce = (func, timeout = 500) => {
    let timer;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => {
            func.apply(this, args);
        }, timeout);
    };
};

defineProps({
    connectors: {
        type: Array,
        default: () => [],
    }
});

const searchValue = ref("");
// const connectors = ref([]);


const performSearch = debounce(async () => {
    Inertia.get(`/search/${searchValue.value}`);
});


watch(searchValue, performSearch);
</script>

<template>
    <Head title="EV Charger Tools" />

    <div
        class="
            items-top
            justify-center
            min-h-screen
            bg-gray-100
            dark:bg-gray-900
            sm:items-center sm:pt-0
        "
        style="padding-bottom: 25px"
    >
        <NavBar />

        <Container>
            <div class="dark:text-white">
                <p class="mb-2 text-xl">Welcome to some page.</p>

                <p class="mb-2">Description...</p>

                <div class="mb-2">
                    <input
                        v-model="searchValue"
                        type="text"
                        name="search"
                        placeholder="Search stations (by address)"
                        class="
                            w-full
                            px-4
                            py-2
                            border
                            rounded-lg
                            focus:outline-none
                            focus:ring-2
                            focus:ring-blue-600
                            focus:border-transparent
                        "
                    />
                </div>

                <div class="mb-2">
                    <div
                        v-for="connector in connectors"
                        :key="connector.id"
                    >
                        <connector :connector="connector" />
                    </div>
                </div>
            </div>
        </Container>
    </div>
</template>

<style>
progress::-webkit-progress-bar {
    background-color: white;
}

progress::-webkit-progress-value {
    transition: width 0.1s;
}
</style>
