<template>
    <div class="notification has-text-centered" :class="classe" v-show="isShown">
        <button v-if="own_close" class="delete" @click="$emit('close')"></button>
        <button  class="delete" @click="CloseIt" v-if="!own_close"></button>
        <slot></slot>
    </div>
</template>

<script>

    export default {
        props:{
            classe: {default: 'is-primary'},
            text_close: {default: 'true'}
        },

        data(){
            return{
                isShown: true,
            }
        },

        computed:{
            own_close(){
                if(this.text_close === 'true')
                {
                    return true;
                }
                else {
                    return false;
                }
            }
        },

        mounted(){

        },

        methods:{
            CloseIt()
            {
                this.isShown = false;
            }
        }
    }
</script>