<template>
    <div class="card">
        <div class="card-header">{{ title }}</div>
        <div class="card-body">
            <slot></slot>
        </div>
        <div class="card-footer"><slot name="footer"></slot></div>
    </div>
</template>

<script>
    export default {
        name: "ProfileCard",
        props : ['title', 'image', 'company_name', 'company_web'],
        mounted() {

        },
        data() {
            return {

            }
        }
    }
</script>

<style>

</style>
