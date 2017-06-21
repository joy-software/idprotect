<template>
    <div class="card">
        <div class="card-content" >
            <div class="media">
                <div class="media-left " v-if="type === 'video'">
                    <figure class="image is-48x48">
                        <img src="http://bulma.io/images/placeholders/96x96.png" alt="Image">
                    </figure>
                </div>
                <template v-if="type === 'images'">
                    <figure class="image is-128x128">
                        <img :src="link">
                    </figure>
                    <p class="title is-4" v-html="title"></p>
                </template>
                <div class="media-content" v-else>
                    <p class="title is-4" v-html="title"></p>
                    <p class="subtitle is-6" ><a v-html="link" :href="link"></a></p>
                </div>
            </div>

            <div class="content" v-html="preview" v-if="type !== 'images'">
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props:{
            title: {required: true},
            preview: {required: true},
            link: {required: true},
            type: {required: true}
        },

        data(){
            return{
              //  isActive: false
                //title: this.title,
                //preview: this.preview,
                //link: this.link
            }
        },

        computed:{

          /*  href()
            {
                return '#'+this.name.toLowerCase().replace(/ /g,'-');
            }//*/

        },

        mounted(){
           // this.isActive = this.selected;
            //console.log('Result mounted.');
        },

        methods:{

        }
    }
</script>