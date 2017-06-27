/**
 * Created by hp on 05/06/2017.
 */

const moduleA = {
    state: {
        results: [],
        activeSearch: false,
        progress: 5,
        progressShown: false
    },
    mutations: {
        load (state, payload) {
            state.results = payload
        },
        add(state,payload)
        {
          state.results = state.results.concat(payload);
        },

        active(state)
        {
            state.activeSearch = true;
        },
        deactivate(state)
        {
            state.activeSearch = false;
        },
        activeP(state)
        {
            state.progressShown = true;
        },
        deactivateP(state)
        {
            state.progressShown = false;
        },
        setProgress(state,value)
        {
            state.progress = value;
        }

    },
    actions: {

    },
    getters: {
        // ...

        getResult: (state, getters) => (name) => {
            return state.results.filter(res => res.category === name)
        }
    }
}

export default moduleA;