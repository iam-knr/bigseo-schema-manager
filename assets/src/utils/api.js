/**
 * API Communication Functions
 * Handles all WordPress AJAX requests
 */

const API_CONFIG = {
    baseUrl: window.bigSeoSchema?.ajaxUrl || '/wp-admin/admin-ajax.php',
    nonce: window.bigSeoSchema?.nonce || ''
};

export const makeRequest = async (action, data = {}) => {
    const formData = new URLSearchParams({
        action: action,
        nonce: API_CONFIG.nonce,
        ...data
    });

    try {
        const response = await fetch(API_CONFIG.baseUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: formData
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();
        
        if (!result.success) {
            throw new Error(result.data?.message || 'Request failed');
        }

        return result.data;
    } catch (error) {
        console.error('API Request Error:', error);
        throw error;
    }
};

export const getSchemaDefinition = async (schemaType) => {
    return makeRequest('get_schema_definition', { schema_type: schemaType });
};

export const saveSchema = async (postId, schemaType, schemaData) => {
    return makeRequest('save_schema', {
        post_id: postId,
        schema_type: schemaType,
        schema_data: JSON.stringify(schemaData)
    });
};

export const deleteSchema = async (postId) => {
    return makeRequest('delete_schema', { post_id: postId });
};
