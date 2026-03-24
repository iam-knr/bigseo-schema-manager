import React, { useState } from 'react';
import './SchemaPreview.css';

const SchemaPreview = ({ schemaData }) => {
    const [copied, setCopied] = useState(false);

    const formattedSchema = JSON.stringify(schemaData, null, 2);

    const handleCopy = () => {
        navigator.clipboard.writeText(formattedSchema).then(() => {
            setCopied(true);
            setTimeout(() => setCopied(false), 2000);
        });
    };

    const handleDownload = () => {
        const blob = new Blob([formattedSchema], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = 'schema.json';
        link.click();
        URL.revokeObjectURL(url);
    };

    const handleValidate = () => {
        const validationUrl = `https://validator.schema.org/#url=${encodeURIComponent(window.location.href)}`;
        window.open(validationUrl, '_blank');
    };

    return (
        <div className="schema-preview">
            <div className="preview-header">
                <h3>Schema Markup Preview</h3>
                <div className="preview-actions">
                    <button onClick={handleCopy} className="btn-secondary">
                        {copied ? 'Copied!' : 'Copy to Clipboard'}
                    </button>
                    <button onClick={handleDownload} className="btn-secondary">
                        Download JSON
                    </button>
                    <button onClick={handleValidate} className="btn-secondary">
                        Validate Schema
                    </button>
                </div>
            </div>
            <div className="preview-content">
                <pre>
                    <code>{formattedSchema}</code>
                </pre>
            </div>
        </div>
    );
};

export default SchemaPreview;
