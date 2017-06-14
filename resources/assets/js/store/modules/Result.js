/**
 * Created by hp on 05/06/2017.
 */

const moduleA = {
    state: {
        results: [],
        activeSearch: false
    },
    mutations: {
        load (state, payload) {
            state.results = payload
        },
        active(state)
        {
            state.activeSearch = true;
        },
        deactivate(state)
        {
            state.activeSearch = false;
        }

    },
    actions: {

    },
    getters: {

    }
}

export default moduleA;