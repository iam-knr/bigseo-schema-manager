import React from 'react';
import ReactDOM from 'react-dom';
import SchemaForm from './components/SchemaForm';
import './admin.css';

// Initialize schema manager on post edit screen
jQuery(document).ready(function($) {
    const schemaContainer = document.getElementById('bigseo-schema-root');
    
    if (schemaContainer) {
        const schemaType = schemaContainer.dataset.schemaType || '';
        const schemaData = JSON.parse(schemaContainer.dataset.schemaData || '{}');
        const postId = schemaContainer.dataset.postId || '';
        
        ReactDOM.render(
            <SchemaForm 
                schemaType={schemaType}
                schemaData={schemaData}
                postId={postId}
            />,
            schemaContainer
        );
    }
});
