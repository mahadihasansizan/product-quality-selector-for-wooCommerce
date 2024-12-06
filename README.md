# Product Quality Selector For WooCommerce

![Plugin Version](https://img.shields.io/badge/version-1.0.0-blue.svg)
![License](https://img.shields.io/badge/license-GPL%20v2-blue.svg)
![WordPress Compatible](https://img.shields.io/badge/WordPress-6.7%20%7C%20Latest-green.svg)
![WooCommerce Compatible](https://img.shields.io/badge/WooCommerce-7.0%20%7C%20Latest-green.svg)

**Product Quality Selector For WooCommerce** is a versatile WordPress plugin that enhances your WooCommerce store by displaying a dynamic dot selector on single product pages to indicate product quality. Seamlessly integrating with Elementor, this plugin offers customizable colors, font styles, and alignment options, providing both store owners and customers with an intuitive and visually appealing way to showcase product conditions.

---

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
  - [Setting Up Product Conditions](#setting-up-product-conditions)
  - [Using the Elementor Widget](#using-the-elementor-widget)
  - [Using the Shortcode](#using-the-shortcode)
- [Customization](#customization)
- [Screenshots](#screenshots)
- [Frequently Asked Questions](#frequently-asked-questions)
- [Changelog](#changelog)
- [License](#license)
- [Support](#support)
- [Contributing](#contributing)

---

## Features

- **Dynamic Dot Selector:** Visually represent product quality with an interactive dot selector on single product pages.
- **Elementor Integration:** Easily add the Quality Dot Selector to your pages using Elementor's drag-and-drop interface.
- **Customizable Styles:** Customize dot colors, label fonts, sizes, spacing, and alignment directly from Elementor or via CSS.
- **Custom Taxonomy:** Utilize a custom taxonomy (`condition`) to manage and display various product conditions.
- **Shortcode Support:** Embed the Quality Dot Selector anywhere on your site using a simple shortcode.
- **Translation Ready:** Fully compatible with translation plugins, allowing for a multilingual store experience.

---

## Requirements

- **WordPress:** 5.0 or higher
- **WooCommerce:** 3.0 or higher
- **Elementor:** 3.0 or higher (for Elementor widget integration)
- **PHP:** 7.0 or higher

---

## Installation

1. **Download the Plugin:**
   - Clone the repository or download the ZIP file from GitHub.

2. **Upload to WordPress:**
   - Navigate to your WordPress dashboard.
   - Go to **Plugins > Add New > Upload Plugin**.
   - Click **Choose File** and select the downloaded `product-quality-selector-for-woocommerce.zip` file.
   - Click **Install Now**.

3. **Activate the Plugin:**
   - After installation, click **Activate Plugin**.

4. **Verify Installation:**
   - Ensure that the plugin appears in the **Plugins** list and is active.

---

## Usage

### Setting Up Product Conditions

1. **Access Conditions:**
   - In your WordPress dashboard, navigate to **Products > Conditions**.

2. **Add New Condition:**
   - Click on **Add New** to create a new product condition (e.g., Good, Very Good, Excellent).

3. **Manage Conditions:**
   - Add as many conditions as needed to accurately represent the quality tiers of your products.

### Using the Elementor Widget

1. **Edit with Elementor:**
   - Navigate to the page or product where you want to add the Quality Dot Selector.
   - Click **Edit with Elementor**.

2. **Add the Widget:**
   - In the Elementor panel, search for **Quality Dot Selector**.
   - Drag and drop the widget to your desired location on the page.

3. **Customize Styles:**
   - Use the widget's settings to adjust colors, fonts, sizes, spacing, and alignment as per your preference.

4. **Save Changes:**
   - Once satisfied, click **Update** to save your changes.

### Using the Shortcode

1. **Insert Shortcode:**
   - You can embed the Quality Dot Selector anywhere on your site using the following shortcode:

     ```markdown
     [quality_dot_selector]
     ```

2. **Add to Pages or Posts:**
   - Edit the desired page or post.
   - Add a **Shortcode** block and paste the shortcode above.

3. **Publish or Update:**
   - Save your changes to see the dot selector in action.

---

## Customization

- **Dot Colors:** Customize active and inactive dot colors via Elementor's widget settings or by modifying the CSS.
- **Label Fonts and Sizes:** Adjust font family, size, and weight directly within Elementor or through custom CSS.
- **Alignment:** Align the primary label (e.g., left, center, right) using the alignment control added to the widget settings.
- **Spacing:** Modify the spacing between dots and labels to fit your design needs.

*For advanced customization, refer to the plugin's CSS file located at `assets/css/product-quality-selector-for-woocommerce.css`.*

---

## Screenshots

1. **Quality Dot Selector on Product Page:**

   ![Dot Selector Frontend](assets/images/screenshot-1.png)

2. **Elementor Widget Settings:**

   ![Elementor Widget Settings](assets/images/screenshot-2.png)

3. **Condition Management:**

   ![Condition Management](assets/images/screenshot-3.png)

*Ensure that the screenshots are placed in the `assets/images/` directory and named appropriately.*

---

## Frequently Asked Questions

### How do I add new product conditions?

Navigate to `Products > Conditions` in your WordPress dashboard. Click `Add New` to create additional conditions as needed.

### Can I customize the colors and fonts?

Yes! If you're using Elementor, you can customize the dot colors, label fonts, sizes, and spacing directly from the Elementor widget's `Style` tab. For further customization, you can modify the CSS file located at `assets/css/product-quality-selector-for-woocommerce.css`.

### Is the plugin compatible with the latest version of WooCommerce?

Yes, the plugin is regularly tested and updated to ensure compatibility with the latest versions of WooCommerce and WordPress.

### Does the plugin support multiple product conditions per product?

Currently, the plugin is designed to handle one condition per product. If you require multiple conditions per product, consider extending the plugin or submitting a feature request.

### How do I translate the plugin?

The plugin is translation-ready. Use a translation plugin like [Loco Translate](https://wordpress.org/plugins/loco-translate/) to translate strings. The `.pot` file is located in the `languages/` directory.

---

## Changelog

### 1.0.0
- Initial release.

---

## License

This plugin is licensed under the [GNU General Public License v2 or later](https://www.gnu.org/licenses/gpl-2.0.html).

---

## Support

For support, please open an issue on the [GitHub repository](https://github.com/yourusername/product-quality-selector-for-woocommerce/issues) or contact the author directly at [your.email@example.com](mailto:your.email@example.com).

---

## Contributing

Contributions are welcome! Please follow these steps:

1. **Fork the Repository:** Click the **Fork** button on the top right of the repository page.

2. **Clone Your Fork:**
   ```bash
   git clone https://github.com/mahadihasansizan/product-quality-selector-for-woocommerce.git
