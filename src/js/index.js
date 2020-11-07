import React from 'react';
import ReactDOM from 'react-dom';
import 'semantic-ui-css';
import 'regenerator-runtime/runtime';

import '../css/app.css';

import App from './App';

const rootElement = document.getElementById('app');
ReactDOM.render(<App />, rootElement);
