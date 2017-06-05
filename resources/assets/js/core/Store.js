/**
 * Created by hp on 05/06/2017.
 */

const store = new Vue.Store({
    state: {
        count: 0
    },
    mutations: {
        increment (state) {
            state.count++
        }
    }
})