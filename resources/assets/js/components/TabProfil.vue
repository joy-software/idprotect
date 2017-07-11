<template>
    <div v-show="isActive" class="columns">

        <div class="column is-one-quarter">

            <slot name="tab_left"></slot>
        </div>

        <div class="column is-half">
            <template v-if="(!emptyResult && search) || (!emptyResult && eager)">
                <h1><slot name="before"></slot><strong v-text="number"></strong> <slot name="after"></slot></h1>
            </template>
            <template v-for="resul in results">
                <result-profile  :title="resul.title" :preview="resul.preview" :link="resul.links"
                         :type="resul.category" :statut="resul.statut" :video="resul.videoLink"
                         :id="resul.id" style="margin-bottom: 15px" v-if="!(category === 'images')">
                </result-profile>
                <result-profile  :title="resul.title" :preview="resul.preview" :link="resul.links" :links="resul.link"
                         :type="resul.category" :statut="resul.statut" :video="resul.videoLink"
                         :id="resul.id" style="margin-bottom: 15px" v-else>
                </result-profile>
            </template>
           <alert v-if="emptyResult && search" @close="CloseNotif">
               <slot name="emptyResultMessage"></slot>
           </alert>
            <br/>
            <br/>
         </div>

        <div class="column">
            <profile>

            </profile>
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
            test: []
        }
    },

    computed:{

        href()
        {
            return '#'+this.name.toLowerCase().replace(/ /g,'-');
        },
        category()
        {
            if(this.name === 'All'  || this.name === 'Tout')
            {
                return 'all'
            }
            else if(this.name === 'Videos'){
                return  'video'
            }
            else if(this.name === 'Documents'){
               return  'document'
            }
            else if(this.name === 'Images'){
                return 'images'
            }
            else {
                return  'social'
            }
        },

        results () {
            if(this.$store.getters.getResultP(this.category) === undefined)
            {
                return []
            }
            else {

                return this.$store.getters.getResultP(this.category);
            }
        },

        search(){
            return this.$store.state.a.activeSearch
        },

        eager()
        {
            return this.$store.state.a.eager
        },

        emptyResult(){
            return Object.keys(this.results).length === 0
        },

        number(){
            return Object.keys(this.results).length
        }


    },

    mounted(){
        this.isActive = this.selected;
        //console.log('Component mounted.');
    },

    created(){
        this.results = this.$children;
    },

    methods:{
        CloseNotif(){
            this.$store.commit('deactivate')
        },
    }
}


</script>