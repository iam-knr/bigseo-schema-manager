import React from 'react';

const FormField = ({ field, value, onChange }) => {
    const renderField = () => {
        switch (field.type) {
            case 'text':
            case 'url':
            case 'email':
            case 'date':
                return (
                    <input
                        type={field.type}
                        id={`field-${field.key}`}
                        className="regular-text"
                        value={value}
                        onChange={(e) => onChange(e.target.value)}
                        placeholder={field.placeholder || ''}
                        required={field.required || false}
                    />
                );

            case 'textarea':
                return (
                    <textarea
                        id={`field-${field.key}`}
                        className="large-text"
                        rows="4"
                        value={value}
                        onChange={(e) => onChange(e.target.value)}
                        placeholder={field.placeholder || ''}
                        required={field.required || false}
                    />
                );

            case 'select':
                return (
                    <select
                        id={`field-${field.key}`}
                        value={value}
                        onChange={(e) => onChange(e.target.value)}
                        required={field.required || false}
                    >
                        <option value="">Select...</option>
                        {field.options && Object.entries(field.options).map(([key, label]) => (
                            <option key={key} value={key}>{label}</option>
                        ))}
                    </select>
                );

            default:
                return null;
        }
    };

    return (
        <div className="bigseo-form-field">
            <label htmlFor={`field-${field.key}`}>
                {field.label}
                {field.required && <span className="required">*</span>}
            </label>
            {renderField()}
            {field.help && (
                <p className="description">{field.help}</p>
            )}
        </div>
    );
};

export default FormField;
