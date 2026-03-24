# BigSEO Schema Manager

A comprehensive WordPress plugin to generate and inject JSON-LD schema markup into any page or post automatically.

## Description

BigSEO Schema Manager is a powerful WordPress plugin that enables you to easily add structured data (Schema.org) markup to your website. This helps search engines better understand your content and can lead to enhanced search results with rich snippets.

### Features

- **12+ Schema Types Supported**
  - Article
  - Local Business
  - Product
  - Recipe
  - Event
  - Person
  - Organization
  - Course
  - FAQ
  - Breadcrumb
  - Video
  - Job Posting
  - And more!

- **User-Friendly Interface**
  - Visual schema type selector
  - Dynamic form generation based on schema type
  - Real-time schema preview
  - Copy to clipboard functionality
  - JSON download option
  - Schema validator integration

- **Flexible Integration**
  - Post/Page metabox for per-content schema
  - Global schema settings
  - Automatic schema injection
  - REST API support

- **Developer Friendly**
  - Extensible architecture
  - Custom schema type support
  - Action and filter hooks
  - Clean, documented code

## Installation

1. Upload the plugin files to `/wp-content/plugins/bigseo-schema-manager`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to any post/page editor to add schema markup
4. Or use Settings > BigSEO Schema to configure global schema

## Development Setup

### Prerequisites

- Node.js (v14 or higher)
- npm or yarn
- WordPress development environment

### Build Instructions

```bash
# Install dependencies
npm install

# Development build with watch
npm run dev

# Production build
npm run build
```

## Usage

### Adding Schema to a Post/Page

1. Edit any post or page
2. Scroll to the "Schema Markup" metabox
3. Select your desired schema type
4. Fill in the required fields
5. Preview and validate the generated schema
6. Save your post

### Using the React Interface

The plugin includes a modern React-based interface for schema generation:

- **Schema Type Selector**: Visual grid to choose schema type
- **Dynamic Forms**: Auto-generated forms based on schema definition
- **Live Preview**: See your JSON-LD markup in real-time
- **Validation**: Built-in schema validator integration

## File Structure

```
bigseo-schema-manager/
├── admin/                    # Admin interface classes
│   ├── class-bigseo-admin.php
│   ├── class-bigseo-metabox.php
│   └── views/               # Admin template files
├── assets/src/              # Frontend source files
│   ├── components/          # React components
│   │   ├── SchemaForm.jsx
│   │   ├── SchemaPreview.jsx
│   │   ├── SchemaTypeSelector.jsx
│   │   └── FormField.jsx
│   ├── utils/              # Utility functions
│   ├── App.jsx             # Main React app
│   └── admin.js            # Admin entry point
├── includes/               # Core plugin classes
│   ├── class-bigseo-activator.php
│   ├── class-bigseo-deactivator.php
│   ├── class-bigseo-loader.php
│   ├── class-bigseo-injector.php
│   ├── class-bigseo-generator.php
│   ├── class-bigseo-ajax.php
│   └── class-bigseo-sanitizer.php
├── schema-definitions/      # Schema type definitions
│   ├── article.php
│   ├── product.php
│   ├── recipe.php
│   └── ...
├── public/                 # Public-facing functionality
└── bigseo-schema-manager.php  # Main plugin file
```

## Adding Custom Schema Types

To add a custom schema type:

1. Create a new PHP file in `schema-definitions/`
2. Return an array with schema structure:

```php
<?php
return [
    '@context' => 'https://schema.org',
    '@type' => 'YourType',
    'property' => [
        'type' => 'text',
        'label' => 'Property Label',
        'required' => true
    ]
];
```

## Technical Stack

- **Backend**: PHP 7.4+
- **Frontend**: React 18
- **Build**: Webpack 5, Babel
- **Styling**: CSS3
- **WordPress**: 5.8+

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is licensed under the GPL-3.0 License - see the LICENSE file for details.

## Credits

Developed by Big SEO - Digital Marketing Training Institute

## Support

For support, please open an issue on GitHub or contact us at Digital Academy 360.

## Changelog

### Version 1.0.0
- Initial release
- 12+ schema types supported
- React-based admin interface
- Post/page metabox integration
- Schema validation
- Copy and download functionality
