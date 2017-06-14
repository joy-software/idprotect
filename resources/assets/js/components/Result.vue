<template>
    <div class="card">
        <div class="card-content" >
            <div class="media">
                <!--div class="media-left ">
                    <figure class="image is-48x48">
                        <img src="http://bulma.io/images/placeholders/96x96.png" alt="Image">
                    </figure>
                </div-->
                <div class="media-content">
                    <p class="title is-4" v-html="title"></p>
                    <p class="subtitle is-6"><a v-html="link" :href="link"></a></p>
                </div>
            </div>

            <div class="content" v-html="preview">
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props:{
            title: {required: true},
            preview: {required: true},
            link: {required: true}
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