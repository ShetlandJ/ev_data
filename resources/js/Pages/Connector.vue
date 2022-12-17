<script setup>
import { ref, computed } from "vue";
import { Head, useForm, Link } from "@inertiajs/inertia-vue3";
import Container from "../components/Container.vue";
import NavBar from "../components/NavBar.vue";
import ConnectorStatusList from "../components/ConnectorStatusList.vue";

defineProps({
    connector: {
        type: Object,
        default: () => {},
    }
});
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
                <p class="mb-2 text-xl">Connector page.</p>

                <p class="mb-2">
                    Connector recent statuses:
                </p>

                <connector-status-list />
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
