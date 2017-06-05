<template>
    <div v-show="isActive" class="columns">

        <div class="column is-one-quarter">
            <code class="html">is-one-quarters</code>
            <slot name="tab_left"></slot>
        </div>

        <div class="column is-half">
            <result v-for="resul in results">

                <template slot="title" v-html="resul.title"></template>
                <template slot="link" v-html="resul.link"></template>
                <template v-html="resul.preview"></template>
            </result>
            <br/>
            <slot></slot>
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