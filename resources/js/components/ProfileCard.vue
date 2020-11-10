<template>
    <div class="card">
        <div class="card-header"><slot name="header"></slot></div>
        <div class="card-body">
            <div id="card_header">

            </div>
        </div>
        <div class="card-footer"><slot name="footer"></slot></div>
    </div>
</template>

<script>
    export default {
        name: "ProfileCard",
        mounted() {

        }
    }
</script>

<style>

</style>
