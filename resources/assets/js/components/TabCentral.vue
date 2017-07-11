<template>
    <div v-show="isActive" class="columns">

        <div class="column is-one-quarter">
            <slot name="tab_left"></slot>
        </div>

        <div class="column is-half has-text-centered">
            <div class="tile is-ancestor">
                <slot></slot>
            </div>
        </div>

        <div class="column">
            <slot name="tab_right"></slot>
        </div>
    </div>
</template>

<script>
export default {
    props:{
        name: {required: true},
        selected: {default: false},
        icon: {required: false},
    },

    data(){
        return{
            isActive: false,
            tabs: [],
        }
    },

    computed:{

        href()
        {
            return '#'+this.name.toLowerCase().replace(/ /g,'-');
        },



    },

    mounted(){
        this.isActive = this.selected;
        //console.log('Component mounted.');
    },

    created(){
        this.tabss = this.$children;
    },

    methods:{

    }
}


</script>