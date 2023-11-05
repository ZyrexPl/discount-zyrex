<?php

namespace ZxDiscounts;

class Configuration {
    public function __construct() {
        // Dodaj akcje do ładowania strony z formularzem
        add_action('admin_menu', array($this, 'add_admin_menu'));
    }

    public function add_admin_menu() {
        // Dodaj stronę z formularzem do menu administracyjnego
        add_menu_page('Dodaj Rabat', 'Dodaj Rabat', 'manage_options', 'dodaj-rabat', array($this, 'render_admin_page'));
    }
//tablica wszystkich dostępnych produktów
    public function get_available_products() {
        $products = wc_get_products(array(
            'status' => 'publish', // Ograniczenie do opublikowanych produktów
        ));
        $product_options = array();
        foreach ($products as $product) {
            $product_options[$product->get_id()] = $product->get_name();
        }

        return $product_options;
    }

    public function render_admin_page() {
      echo '<link rel="stylesheet" type="text/css" href="' . plugin_dir_url(__FILE__) . '/admin/css/style.css">';
      // Pobierz dostępne produkty
        $product_options = $this->get_available_products();
        echo '<div class="zx-container">';
        echo '<h2>Dodaj Rabat</h2>';
        echo '<form method="post">';
        echo '<label for="product_ids">Wybierz produkty:</label>';
        echo '<select multiple name="product_ids[]">';

        foreach ($product_options as $product_id => $product_name) {
            echo '<option value="' . $product_id . '">' . $product_name . '</option>';
        }

        echo '</select>';
        echo '<input type="text" name="discount_percent" placeholder="Procent Rabatu">';
        echo '<input type="submit" name="submit" value="Dodaj Rabat">';
        echo '</form>';
        echo '</div>';
    }
}
