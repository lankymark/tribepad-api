// default state
import {ADD_TO_REFERENCES, DELETE_REFERENCES, GET_REFERENCES, GET_REFERENCE_PROVIDERS, UPDATE_REFERENCES} from "../api/strings";

const referencesAPIReducerDefaultState = [];

// reducer which is a pure function
export default (state = referencesAPIReducerDefaultState, action) => {
    switch (action.type) {
        case ADD_TO_REFERENCES:
            return state;
        case DELETE_REFERENCES:
            return state;
        case GET_REFERENCES:
            return state;
        case GET_REFERENCE_PROVIDERS:
            return state;
        case UPDATE_REFERENCES:
            return state;
        default:
            return state;
    }
};
