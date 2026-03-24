import React, { useState, useEffect } from 'react';
import FormField from './FormField';
import SchemaPreview from './SchemaPreview';

const SchemaForm = ({ schemaType, schemaData, postId }) => {
    const [formData, setFormData] = useState(schemaData || {});
    const [schemaDefinition, setSchemaDefinition] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        // Fetch schema definition from WordPress
        fetch(`/wp-json/bigseo/v1/schema-definition/${schemaType}`)
            .then(res => res.json())
            .then(data => {
                setSchemaDefinition(data);
                setLoading(false);
            })
            .catch(err => {
                console.error('Error loading schema:', err);
                setLoading(false);
            });
    }, [schemaType]);

    const handleFieldChange = (key, value) => {
        setFormData(prev => ({
            ...prev,
            [key]: value
        }));
    };

    const handleSave = () => {
        // Save schema data
        fetch(`/wp-json/bigseo/v1/schema/${postId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': window.bigSeoData.nonce
            },
            body: JSON.stringify({
                schema_type: schemaType,
                schema_data: formData
            })
        })
        .then(res => res.json())
        .then(data => {
            alert('Schema saved successfully!');
        })
        .catch(err => {
            alert('Error saving schema');
            console.error(err);
        });
    };

    if (loading) {
        return <div className="bigseo-loading">Loading schema form...</div>;
    }

    if (!schemaDefinition) {
        return <div className="bigseo-error">Error loading schema definition</div>;
    }

    return (
        <div className="bigseo-schema-form">
            <h3>{schemaDefinition.name} Schema</h3>
            <p>{schemaDefinition.description}</p>
            
            {schemaDefinition.fields && schemaDefinition.fields.map(field => (
                <FormField
                    key={field.key}
                    field={field}
                    value={formData[field.key] || ''}
                    onChange={(value) => handleFieldChange(field.key, value)}
                />
            ))}

            <div className="bigseo-form-actions">
                <button 
                    className="button button-primary"
                    onClick={handleSave}
                >
                    Save Schema
                </button>
            </div>

            <SchemaPreview 
                schemaType={schemaType}
                formData={formData}
                schemaDefinition={schemaDefinition}
            />
        </div>
    );
};

export default SchemaForm;
