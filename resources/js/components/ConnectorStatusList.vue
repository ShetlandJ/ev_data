<script setup>
import { usePage } from "@inertiajs/inertia-vue3";
import { formatDateTime } from "../utils/formatters";

const capitalize = (str) => {
    let lower = str.toLowerCase();
    return lower.charAt(0).toUpperCase() + lower.slice(1);
};

const getClass = (status) => {
    switch (status) {
        case "AVAILABLE":
            return "available";
        case "OCCUPIED":
        case "UNAVAILABLE":
            return "unavailable";
        default:
            return "unknown";
    }
};

const connector = usePage().props.value.connector;
</script>

<template>
    <div v-for="stateChange in connector.status_changes" :key="stateChange.id">
        <div class="flex">
            <div class="mr-3">{{ formatDateTime(stateChange.created_at) }}</div>

            <div class="mr-2 flex items-center">
                <div
                    class="availability-dot mr-2"
                    :class="getClass(stateChange.old_status)"
                />
                {{ capitalize(stateChange.old_status) }}
            </div>
            <div>TO</div>
            <div class="ml-2 flex items-center">
                <div
                    class="availability-dot mr-2"
                    :class="getClass(stateChange.new_status)"
                />
                {{ capitalize(stateChange.new_status) }}
            </div>
        </div>
    </div>
</template>


<style scoped>
.availability-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
}

.unavailable {
    background-color: #db4325;
}

.available {
    background-color: #57c4ad;
}

.unknown {
    background-color: darkgrey;
}
</style>