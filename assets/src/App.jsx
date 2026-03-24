import React, { useState } from 'react';
import SchemaTypeSelector from './components/SchemaTypeSelector';
import SchemaForm from './components/SchemaForm';
import SchemaPreview from './components/SchemaPreview';
import './App.css';

const App = () => {
    const [selectedType, setSelectedType] = useState('');
    const [schemaData, setSchemaData] = useState(null);

    const handleTypeChange = (type) => {
        setSelectedType(type);
        setSchemaData(null);
    };

    const handleSchemaGenerate = (data) => {
        setSchemaData(data);
    };

    return (
        <div className="bigseo-schema-manager">
            <header className="app-header">
                <h1>BigSEO Schema Manager</h1>
                <p>Generate JSON-LD structured data for better SEO</p>
            </header>
            
            {!selectedType ? (
                <SchemaTypeSelector 
                    selectedType={selectedType}
                    onTypeChange={handleTypeChange}
                />
            ) : (
                <div className="schema-workspace">
                    <button 
                        className="btn-back"
                        onClick={() => handleTypeChange('')}
                    >
                        ← Back to Schema Types
                    </button>
                    
                    <SchemaForm 
                        schemaType={selectedType}
                        onGenerate={handleSchemaGenerate}
                    />
                    
                    {schemaData && (
                        <SchemaPreview schemaData={schemaData} />
                    )}
                </div>
            )}
        </div>
    );
};

export default App;
