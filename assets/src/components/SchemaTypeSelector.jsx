import React from 'react';
import './SchemaTypeSelector.css';

const SchemaTypeSelector = ({ selectedType, onTypeChange }) => {
    const schemaTypes = [
        { value: 'article', label: 'Article', icon: '📄' },
        { value: 'local-business', label: 'Local Business', icon: '🏢' },
        { value: 'product', label: 'Product', icon: '🛍️' },
        { value: 'recipe', label: 'Recipe', icon: '🍳' },
        { value: 'event', label: 'Event', icon: '📅' },
        { value: 'person', label: 'Person', icon: '👤' },
        { value: 'organization', label: 'Organization', icon: '🏛️' },
        { value: 'course', label: 'Course', icon: '📚' },
        { value: 'faq', label: 'FAQ', icon: '❓' },
        { value: 'breadcrumb', label: 'Breadcrumb', icon: '🔗' },
        { value: 'video', label: 'Video', icon: '🎥' },
        { value: 'job-posting', label: 'Job Posting', icon: '💼' }
    ];

    return (
        <div className="schema-type-selector">
            <h2>Select Schema Type</h2>
            <div className="schema-types-grid">
                {schemaTypes.map((type) => (
                    <div
                        key={type.value}
                        className={`schema-type-card ${
                            selectedType === type.value ? 'selected' : ''
                        }`}
                        onClick={() => onTypeChange(type.value)}
                    >
                        <div className="type-icon">{type.icon}</div>
                        <div className="type-label">{type.label}</div>
                    </div>
                ))}
            </div>
        </div>
    );
};

export default SchemaTypeSelector;
