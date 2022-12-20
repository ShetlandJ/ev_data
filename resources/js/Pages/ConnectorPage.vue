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
                <p class="mb-2 text-2xl">{{connector.station.fullAddress}}.</p>

                <div v-if="connector.station.tariff_amount">
                    £{{connector.station.tariff_amount}} per kWh
                </div>

                <template v-if="connector.status_changes.length > 0">
                <p class="mb-2 text-lg">
                    Connector recent usage:
                </p>

                <connector-status-list />
                </template>
                <!-- v-else show info alert that no status changes were found -->
                <div
                    v-else
                    class="mt-3 bg-blue-100 border-t-4 border-blue-500 rounded-b text-blue-900 px-4 py-3 shadow-md"
                    role="alert"
                >
                    <div class="flex">
                        <div>
                            <p class="font-bold">No usage history found</p>
                            <p class="text-sm">
                                We have do not have usage history for this
                                connector available at the moment, sorry.
                            </p>
                        </div>
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
