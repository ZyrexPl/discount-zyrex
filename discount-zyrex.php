<?php
/*
Plugin Name: Discount Zyrex
Description: Automatically adds the discount to the order Woocommerce
Version: 1.0
Author: Zyrex
Author URI: http://zyrex.pl
Plugin URI: http://zyrex.pl/plugin/discount
*/
//require_once 'class/configuration.php';
require_once(plugin_dir_path(__FILE__) . '/class/Autoloader.php');

$zxconfig = new ZxDiscounts\Configuration();
// Funkcja aktywacyjna
function discount_zyrex_activate() {
    // Tworzenie tabel w bazie danych
    global $wpdb;
    $table_name_discounts = $wpdb->prefix . 'zx_discounts';
    $table_name_products = $wpdb->prefix . 'zx_products';
    $table_name_reports = $wpdb->prefix . 'zx_reports';

    // SQL do tworzenia tabel
    $sql_discounts = "CREATE TABLE $table_name_discounts (
        id INT NOT NULL AUTO_INCREMENT,
        product_id INT NOT NULL,
        discount_percent DECIMAL(5,2) NOT NULL,
        PRIMARY KEY (id)
    ) $wpdb->charset $wpdb->collate;";

    $sql_products = "CREATE TABLE $table_name_products (
        id INT NOT NULL AUTO_INCREMENT,
        product_id INT NOT NULL,
        PRIMARY KEY (id)
    ) $wpdb->charset $wpdb->collate;";

    $sql_reports = "CREATE TABLE $table_name_reports (
        id INT NOT NULL AUTO_INCREMENT,
        report_date DATE NOT NULL,
        product_id INT NOT NULL,
        quantity INT NOT NULL,
        PRIMARY KEY (id)
    ) $wpdb->charset $wpdb->collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql_discounts);
    dbDelta($sql_products);
    dbDelta($sql_reports);
}

register_activation_hook(__FILE__, 'discount_zyrex_activate');

// Funkcja dodająca rabat
function zx_add_discount($cart) {
    if (is_admin() && !defined('DOING_AJAX')) return;

	$produkt_id = 25; // ID produktu, dla którego obowiązuje rabat

    $ilosc_produktow_w_koszyku = 0;
	// Zlicz ilość produktu o określonym ID w koszyku
    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        if ($cart_item['product_id'] == $produkt_id) {
            $ilosc_produktow_w_koszyku += $cart_item['quantity'];
        }
    }

    // Dodaj rabat, jeśli ilość produktu w koszyku spełnia warunek
    if ($ilosc_produktow_w_koszyku >= 4) {
        // Oblicz rabat na podstawie kwoty produktu
        $produkt = wc_get_product($produkt_id);
        $cena_produktu = $produkt->get_price();
		print_r($cena_produktu);
        $rabat = $ilosc_produktow_w_koszyku * $cena_produktu * (3 / 100);
        WC()->cart->add_fee('Rabat', -$rabat);
    } else if ($ilosc_produktow_w_koszyku == 3) {
		$produkt = wc_get_product($produkt_id);
        $cena_produktu = $produkt->get_price();
		print_r($cena_produktu);
        $rabat = $ilosc_produktow_w_koszyku * $cena_produktu * (2 / 100);
        WC()->cart->add_fee('Rabat', -$rabat);
	} else if ($ilosc_produktow_w_koszyku == 2) {
		$produkt = wc_get_product($produkt_id);
        $cena_produktu = $produkt->get_price();
		print_r($cena_produktu);
        $rabat = $ilosc_produktow_w_koszyku * $cena_produktu * (1 / 100);
        WC()->cart->add_fee('Rabat', -$rabat);
	}
}

add_action('woocommerce_cart_calculate_fees', 'zx_add_discount');
