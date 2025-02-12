 <template>
    <div >
        <div class="card">
            <div class="card-header">Example Component</div>

            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                <slot></slot>
                <button class="btn btn-primary" @click="popup">Press Me!</button>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },

        methods: {
            popup() {
                alert("Pressed!");      
            }
        }
    }
</script>
