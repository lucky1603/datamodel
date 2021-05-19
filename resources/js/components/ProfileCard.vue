<template>
    <div class="card ">
        <div class="card-header bg-dark text-light">{{ title }}</div>
        <div class="card-body">
            <slot></slot>
        </div>
        <div class="card-footer" v-if="hasFooter"><slot name="footer"></slot></div>
    </div>
</template>

<script>
    export default {
        name: "ProfileCard",
        props : ['title', 'image', 'company_name', 'company_web', {name: 'hasFooter', type: Boolean, default: false}],
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
