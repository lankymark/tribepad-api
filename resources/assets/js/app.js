import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import configureStore from './store/configureStore';
import 'normalize.css/normalize.css';
import '../sass/app.scss';
import HomePage from './components/HomePage';

const store = configureStore();

const jsx = (
    <Provider store={store}>
        <HomePage />
    </Provider>
);

const appRoot = document.getElementById('app');
ReactDOM.render(jsx, appRoot);
