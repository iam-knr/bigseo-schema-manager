/**
 * Schema Generator Utility Functions
 * Handles schema generation and API communication
 */

export const generateSchema = async (schemaType, formData) => {
    try {
        const response = await fetch(bigSeoSchema.ajaxUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'generate_schema',
                nonce: bigSeoSchema.nonce,
                schema_type: schemaType,
                form_data: JSON.stringify(formData)
            })
        });

        const data = await response.json();
        
        if (!data.success) {
            throw new Error(data.data.message || 'Schema generation failed');
        }
        
        return data.data.schema;
    } catch (error) {
        console.error('Schema generation error:', error);
        throw error;
    }
};

export const validateSchema = (schema) => {
    if (!schema['@context'] || !schema['@type']) {
        return {
            valid: false,
            errors: ['Schema must have @context and @type']
        };
    }
    
    return {
        valid: true,
        errors: []
    };
};

export const formatSchemaForDisplay = (schema) => {
    return JSON.stringify(schema, null, 2);
};

export const sanitizeFormData = (formData) => {
    const sanitized = {};
    
    for (const [key, value] of Object.entries(formData)) {
        if (value !== '' && value !== null && value !== undefined) {
            sanitized[key] = value;
        }
    }
    
    return sanitized;
};
