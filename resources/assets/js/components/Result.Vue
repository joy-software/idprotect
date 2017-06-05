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
                    <p class="title is-3"><slot name="title"></slot></p>
                    <p class="subtitle is-6"><a><slot name="link"></slot></a></p>
                </div>
            </div>

            <div class="content">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props:{

        },

        data(){
            return{
              //  isActive: false,


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
            console.log('Result mounted.');
        },

        methods:{

        }
    }
</script>