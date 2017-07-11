/**
 * Created by hp on 05/06/2017.
 */

const moduleA = {
    state: {
        results: [],
        resultsProfile: [],
        profile: {},
        activeSearch: false,
        progress: 5,
        progressShown: false,
        url: '/',
        recherche: true,
        profil: false,
        rechercherprofil: false,
        activateprofil: false,
        activaterecherche:false,
        eager:false,
    },
    mutations: {
        load (state, payload) {
            state.results = payload
        },
        loadP (state, payload) {
            state.resultsProfile = payload
        },
        loadProfile (state, payload) {
            state.profile = payload
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
        },
        setUrl(state,value)
        {
            state.url = value;
        },
        setrecherche(state,value)
        {
            state.recherche = value;
        },
        setprofil(state,value)
        {
            state.profil = value;
        },
        setrechercherprofil(state,value)
        {
            state.rechercherprofil = value;
        },
        setactivateprofil(state,value)
        {
            state.activateprofil = value;
        },
        setactivaterecherche(state,value)
        {
            state.activaterecherche = value;
        },
        seteager(state,value)
        {
            state.eager = value;
        }

    },
    actions: {

    },
    getters: {
        // ...

        getResult: (state, getters) => (name) => {
            return state.results.filter(res => res.category === name)
        },
        getResultP: (state, getters) => (name) => {
            return state.resultsProfile.filter(res => res.category === name)
        }
    }
}

export default moduleA;