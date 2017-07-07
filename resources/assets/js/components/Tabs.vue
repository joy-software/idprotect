<template>
    <div>
        <nav class="nav has-shadow" id="nav_tab">
            <div class="container">
                <div class="nav-center has-text-centered">
                    <a v-for="tab in tabs"  class="nav-item is-tab" :class="{'is-active': tab.isActive}" :href="tab.href" @click="selectTab(tab)">
                       <span class="icon is-small">
                             <i class="fa " :class="tab.icon"></i>
                        </span> {{tab.name}}
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