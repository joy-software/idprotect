<template>
    <div>
        <nav class="nav has-shadow">
            <div class="container">
                <div class="nav-center">
                    <a v-for="tab in tabs"  class="nav-item is-tab" :class="{'is-active': tab.isActive}" :href="tab.href" @click="selectTab(tab)">
                        {{tab.name}}
                    </a>
                </div>
            </div>
        </nav>
        <section class="section">
            <div  class="container">
                <slot></slot>
            </div>
        </section>
    </div>
</template>

<script>

export default {
    data(){
       return {
           tabs: [],
           result: []
       }
    },

    created(){
       this.tabs = this.$children;

    },

    methods:{
      selectTab(clickedtab){
        this.tabs.forEach(tab => {
            tab.isActive = (tab.name == clickedtab.name)
        })
      },

    }
}
</script>