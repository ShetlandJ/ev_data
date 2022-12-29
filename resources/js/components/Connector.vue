<script setup>
import { Link } from "@inertiajs/inertia-vue3";

defineProps({
    connector: {
        type: Object,
        default: () => {},
    },
});

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
</script>

<template>
    <Link
        class="
            p-2
            my-2
            items-center
            leading-none
            flex
            cursor-pointer
            bg-blue-600
            text-white
            flex
            justify-between
        "
        :href="`/connector/${connector.id}`"
    >
        <div>
            {{ connector.station.address_sitename }} ({{
                connector.connector_id
            }})
        </div>
        <div class="flex items-center">
            <span class="mr-3">{{ connector.status_changes.length }}</span>

            <div class="availability-dot" :class="getClass(connector.status)" />

            <div
                class="text-2xl ml-4 text-white"
                :class="[
                    connector.station.tariff_amount ? 'has-price' : 'no-price',
                ]"
            >
                <strong>£</strong>
            </div>

            <div class="align-items-center ml-4 underline">Stats</div>
        </div>
    </Link>
</template>

<style scoped>
.has-price {
    color: rgb(255, 134, 152);
}

.no-price {
    color: lightgray;
    opacity: 0.5;
}

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