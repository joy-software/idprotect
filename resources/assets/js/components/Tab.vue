<template>
    <div v-show="isActive" class="columns">

        <div class="column is-one-quarter">
            <code class="html">is-one-quarters</code>
            <slot name="tab_left"></slot>
        </div>

        <div class="column is-half">
            <template v-for="resul in results">
                <result  :title="resul.title" :preview="resul.preview" :link="resul.link" style="margin-bottom: 15px">
                </result>
            </template>
            <br/>
            <br/>
         </div>

        <div class="column">
            <code class="html">auto</code>
            <slot name="tab_right"></slot>
        </div>
    </div>
</template>

<script>
export default {
    props:{
        name: {required: true},
        selected: {default: false},
    },

    data(){
        return{
            isActive: false,
            test: []
        }
    },

    computed:{

        href()
        {
            return '#'+this.name.toLowerCase().replace(/ /g,'-');
        },

        results () {
            return this.$store.state.a.results
        }

    },

    mounted(){
        this.isActive = this.selected;
        console.log('Component mounted.');
    },

    created(){
        this.results = this.$children;
    },
}


</script>