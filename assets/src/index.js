import React from 'react';
import ReactDOM from 'react-dom';
import App from './App';

// Wait for DOM to be ready
window.addEventListener('DOMContentLoaded', () => {
    const rootElement = document.getElementById('bigseo-schema-root');
    
    if (rootElement) {
        ReactDOM.render(
            <React.StrictMode>
                <App />
            </React.StrictMode>,
            rootElement
        );
    }
});
