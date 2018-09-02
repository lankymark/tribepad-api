import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import { createStore, applyMiddleware } from 'redux';
import {Router,Route,IndexRoute,browserHistory} from 'react-router';
import thunk from 'redux-thunk';
import {AUTH_USER} from './actions/types';

import App from './components/app';
import Welcome from './components/welcome';
import reducers from './reducers';

const createStoreWithMiddleware = applyMiddleware(thunk)(createStore);
const store = createStoreWithMiddleware(reducers);
const token = localStorage.getItem('token');

if(token){
  store.dispatch({type:AUTH_USER});
}

ReactDOM.render(
  <Provider store={store}>
    <Router history ={browserHistory}>
      <Route path="/" component={App}>
        <IndexRoute  component={Welcome} />
      </Route>
    </Router>
  </Provider>
  , document.querySelector('.container'));
