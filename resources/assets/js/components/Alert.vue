<template>
    <div class="notification is-primary has-text-centered">
        <button class="delete" @click="$emit('close')"></button>
        <slot></slot>
    </div>
</template>

<script>

    export default {
        props:{

        },

        data(){
            return{

            }
        },

        computed:{

        },

        mounted(){

        },

        methods:{

        }
    }
</script>