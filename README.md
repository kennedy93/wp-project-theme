# WP Project Theme

A modern, responsive WordPress theme designed specifically for showcasing projects. Built with clean, semantic code and featuring a custom REST API for projects data integration.

## Features

- **Responsive Design**: Mobile-first approach with modern CSS Grid and Flexbox
- **Custom Post Type**: Built-in Projects post type with custom fields
- **REST API Integration**: Custom API endpoints for projects data
- **Ajax Filtering**: Dynamic project filtering with date ranges
- **Modern Typography**: Google Fonts (Poppins) integration
- **Icon Support**: Font Awesome 6.4.0 included
- **SEO Optimized**: Proper markup and WordPress SEO best practices
- **Custom Templates**: Specialized templates for different page types
- **Widget Ready**: Custom sidebar with widget support

## Installation

1. **Download or Clone** this repository to your WordPress themes directory:
   ```bash
   cd /path/to/wordpress/wp-content/themes/
   git clone https://github.com/kennedy93/wp-project-theme.git
   ```

2. **Activate the Theme** through the WordPress admin panel:
   - Go to `Appearance > Themes`
   - Find "WP Project Theme" and click "Activate"

3. **Configure Permalinks** (Required for API endpoints):
   - Go to `Settings > Permalinks`
   - Select "Post name" or any custom structure
   - Click "Save Changes"

## Theme Setup

### Required Configuration

1. **Set Homepage Template**:
   - Create a new page and assign the "Home Page" template
   - Go to `Settings > Reading` and set this page as your homepage

2. **Configure Navigation**:
   - Go to `Appearance > Menus`
   - Create a menu and assign it to "Primary Menu" location

3. **Upload Logo** (Optional):
   - Go to `Appearance > Customize > Site Identity`
   - Upload your site logo

### Custom Fields Setup

The theme automatically creates these custom fields for Projects:

- **Project Name**: Internal project identifier
- **Project Description**: Detailed project description
- **Project URL**: Live project URL
- **Project Start Date**: Project start date
- **Project End Date**: Project completion date

## Template Structure

### Page Templates

- `page-home.php` - Homepage template with hero section and featured projects
- `page-blog.php` - Blog listing page template
- `archive-project.php` - Projects archive page with filtering
- `single-project.php` - Individual project detail page
- `page.php` - Default page template
- `single.php` - Default single post template
- `index.php` - Fallback template

### Template Parts

- `template-parts/content.php` - Default post content
- `template-parts/content-project-card.php` - Project card component
- `template-parts/content-none.php` - No content found template

## Projects API

### API Endpoints

The theme provides a custom REST API for accessing projects data:

#### Get Projects
```
GET /wp-json/wp-project/v1/projects
```

#### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `per_page` | integer | 10 | Number of projects per page |
| `page` | integer | 1 | Page number for pagination |
| `start_date` | string | - | Filter by project start date (YYYY-MM-DD) |
| `end_date` | string | - | Filter by project end date (YYYY-MM-DD) |

#### Example Requests

**Get all projects (paginated):**
```bash
curl "https://yoursite.com/wp-json/wp-project/v1/projects"
```

**Get projects with pagination:**
```bash
curl "https://yoursite.com/wp-json/wp-project/v1/projects?per_page=5&page=2"
```

**Filter projects by date range:**
```bash
curl "https://yoursite.com/wp-json/wp-project/v1/projects?start_date=2024-01-01&end_date=2024-12-31"
```

#### Response Format

```json
{
  "projects": [
    {
      "id": 123,
      "title": "Project Title",
      "project_name": "Internal Project Name",
      "project_description": "Detailed description",
      "project_url": "https://project-url.com",
      "project_start_date": "2024-01-01",
      "project_end_date": "2024-06-01",
      "permalink": "https://yoursite.com/projects/project-title/",
      "excerpt": "Project excerpt..."
    }
  ],
  "total": 25,
  "pages": 3,
  "current_page": 1
}
```

## JavaScript Integration

### AJAX Functionality

The theme includes AJAX functionality for dynamic project filtering. The main JavaScript file is located at `js/main.js`.

#### Using the API with JavaScript

```javascript
// Fetch projects using the REST API
fetch('/wp-json/wp-project/v1/projects?per_page=6')
  .then(response => response.json())
  .then(data => {
    console.log('Projects:', data.projects);
    console.log('Total:', data.total);
  });
```

#### AJAX Localization

The theme provides AJAX support with the following localized variables:

```javascript
// Available globally as wpProjectAjax
wpProjectAjax.ajaxurl  // WordPress AJAX URL
wpProjectAjax.nonce    // Security nonce
```

## Customization

### CSS Variables

The theme uses CSS custom properties for easy customization. Main variables are defined in `style.css`:

```css
:root {
    --primary: #1a365d;
    --secondary: #2c5282;
    --accent: #d4a017;
    --light: #f8fafc;
    --dark: #1e293b;
    /* ... more variables */
}
```

### Adding Custom Styles

1. **Child Theme** (Recommended):
   Create a child theme and override styles in the child theme's `style.css`

2. **Customizer**:
   Use `Appearance > Customize > Additional CSS` for small customizations

### Extending Functionality

#### Adding Custom Fields

To add custom fields to projects, use the existing meta box callback in `functions.php`:

```php
// Add to wp_project_meta_box_callback function
echo '<p><label for="custom_field">Custom Field:</label>';
echo '<input type="text" id="custom_field" name="custom_field" value="' . esc_attr($custom_field) . '" size="25" /></p>';
```

#### Custom API Endpoints

To add new API endpoints, follow the pattern in `functions.php`:

```php
function custom_register_api_endpoints() {
    register_rest_route('wp-project/v1', '/custom-endpoint', array(
        'methods' => 'GET',
        'callback' => 'custom_api_callback',
        'permission_callback' => '__return_true',
    ));
}
add_action('rest_api_init', 'custom_register_api_endpoints');
```

## Browser Support

- Chrome 60+
- Firefox 55+
- Safari 11+
- Edge 16+
- iOS Safari 11+
- Android Chrome 60+

## Dependencies

### WordPress Requirements
- WordPress 5.0+
- PHP 8.1+

### External Dependencies
- Google Fonts (Poppins)
- Font Awesome 6.4.0

## Development

### File Structure
```
wp-project-theme/
├── style.css              # Main stylesheet
├── functions.php          # Theme functions and hooks
├── index.php             # Main template
├── header.php            # Site header
├── footer.php            # Site footer
├── sidebar.php           # Sidebar template
├── searchform.php        # Search form
├── page-home.php         # Homepage template
├── page-blog.php         # Blog page template
├── page.php              # Default page template
├── single.php            # Single post template
├── single-project.php    # Single project template
├── archive-project.php   # Projects archive
├── js/
│   └── main.js           # Main JavaScript file
├── template-parts/
│   ├── content.php
│   ├── content-project-card.php
│   └── content-none.php
└── screenshot.png        # Theme screenshot
```

### Local Development

1. Set up a local WordPress environment
2. Clone this theme to your themes directory
3. Activate the theme
4. Create sample projects for testing

## Support

For support, bug reports, or feature requests:

1. **Issues**: Create an issue on the GitHub repository
2. **Documentation**: Check this README for common questions
3. **WordPress Forums**: Post in the WordPress support forums

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Changelog

### Version 1.0.1
- Initial release
- Custom Projects post type
- REST API endpoints
- Responsive design
- AJAX filtering

## License

This theme is licensed under the GPL v2 or later.

```
WP Project Theme
Copyright (C) 2024 Francis Rodrick

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
```

## Credits

- **Developer**: Francis Rodrick
- **Icons**: Font Awesome
- **Fonts**: Google Fonts (Poppins)
- **Framework**: WordPress

---

**Theme URI**: https://wp-project.appbusket.com  
**Author**: Francis Rodrick  
**Version**: 1.0.1  
**License**: GPL v2 or later
