<?php

namespace lii\ajax\cart\Admin;

/**
 * The Woocommerce Submenu_Page class
 *
 * @since 1.1
 */

class Submenu_Page
{
	public function __construct()
	{
		add_action('admin_menu', array($this, 'create_settings'));
		add_action('admin_init', array($this, 'setup_sections'));
		add_action('admin_init', array($this, 'setup_fields'));
	}

	public function create_settings()
	{
		$parent_slug = 'woocommerce';
		$page_title = 'Appify Side Cart';
		$menu_title = 'Appify Side Cart';
		$capability = 'manage_options';
		$slug = 'appify-side-cart';
		$callback = array($this, 'settings_content');
		add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $slug, $callback);
	}

	public function settings_content()
	{ ?>
		<div class="wrap">
			<h1>Appify Side Cart</h1>
			<?php settings_errors(); ?>
			<form method="POST" action="options.php">
				<?php
				settings_fields('SideCart');
				do_settings_sections('SideCart');
				submit_button();
				?>
			</form>
		</div> <?php
			}

			public function setup_sections()
			{
				add_settings_section('SideCart_section', '', array(), 'SideCart');
			}

			public function setup_fields()
			{
				$fields = array(
					array(
						'section' => 'SideCart_section',
						'label' => 'Ajax add to cart in shop page',
						'id' => 'Lii-ajax-add-to-cart-option',
						'desc' => 'Add to cart without refreshing shop page',
						'type' => 'checkbox',
					),

					array(
						'section' => 'SideCart_section',
						'label' => 'Ajax add to cart in single product page',
						'id' => 'Lii-ajax-single-product-page-add-to-cart-option',
						'desc' => 'Add to cart without refreshing single product page',
						'type' => 'checkbox',
					),

					array(
						'section' => 'SideCart_section',
						'label' => 'Disable product quantity box?',
						'id' => 'Lii-showing-product-quantity-box-option',
						'desc' => 'Product showing product quantity box',
						'type' => 'checkbox',
					),

					array(
						'section' => 'SideCart_section',
						'label' => 'Cart Order',
						'id' => 'Lii-cart-order-option',
						'desc' => 'If you have bundle/composite products use Asc order',
						'type' => 'select',
						'options' => array(
							'Recently added item at last (Asc)',
							'Recently added item at top (Desc)'
						)
					),
				);
				foreach ($fields as $field) {
					add_settings_field($field['id'], $field['label'], array($this, 'field_callback'), 'SideCart', $field['section'], $field);
					register_setting('SideCart', $field['id']);
				}
			}
			public function field_callback($field)
			{
				$value = get_option($field['id']);

				$placeholder = '';
				if (isset($field['placeholder'])) {
					$placeholder = $field['placeholder'];
				}
				switch ($field['type']) {


					case 'select':
					case 'multiselect':
						if (!empty($field['options']) && is_array($field['options'])) {
							$attr = '';
							$options = '';
							foreach ($field['options'] as $key => $label) {
								$options .= sprintf(
									'<option value="%s" %s>%s</option>',
									$key,
									selected($value, $key, false),
									$label
								);
							}
							if ($field['type'] === 'multiselect') {
								$attr = ' multiple="multiple" ';
							}
							printf(
								'<select name="%1$s" id="%1$s" %2$s>%3$s</select>',
								$field['id'],
								$attr,
								$options
							);
						}
						break;

					case 'checkbox':
						$value = get_option($field['id']);
						printf(
							'<input %s id="%s" name="%s" type="checkbox" value="1">',
							$value === '1' ? 'checked' : '',
							$field['id'],
							$field['id']
						);
						break;

					default:
						printf(
							'<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />',
							$field['id'],
							$field['type'],
							$placeholder,
							$value
						);
				}
				if (isset($field['desc'])) {
					if ($desc = $field['desc']) {
						printf('<p class="description">%s </p>', $desc);
					}
				}
			}
		}
