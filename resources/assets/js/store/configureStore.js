import { createStore, combineReducers, applyMiddleware } from 'redux';
import referenceAPIReducer from '../reducers/referenceAPI';
import thunk from 'redux-thunk';

const rootReducer = combineReducers({
    shoppingCart: referenceAPIReducer
});

export default () => {
    const store = createStore(
        rootReducer,
        applyMiddleware(thunk)
    );

    return store;
};
