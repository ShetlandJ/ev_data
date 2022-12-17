<script setup>
import { usePage } from "@inertiajs/inertia-vue3";

const connector = usePage().props.value.connector;
</script>

<template>
    <div v-for="stateChange in connector.status_changes" :key="stateChange.id">
        <div>{{connector.old_status}}</div>
        <div>{{connector.new_status}}</div>
        <div>{{connector.created_at}}</div>
        {{connector.status_changes}}
    </div>
</template>


<style lang="scss" scoped>

</style>