<?php
class DiscountZyrexPlugin {
    public function __construct() {
        // Dodaj akcje do ładowania strony z formularzem
        add_action('admin_menu', array($this, 'add_admin_menu'));
    }

    public function add_admin_menu() {
        // Dodaj stronę z formularzem do menu administracyjnego
        add_menu_page('Dodaj Rabat', 'Dodaj Rabat', 'manage_options', 'dodaj-rabat', array($this, 'render_admin_page'));
    }

    public function render_admin_page() {
        // Tutaj możesz wyrenderować formularz do dodawania rabatu
        // Przykład:
        echo '<div class="wrap">';
        echo '<h2>Dodaj Rabat</h2>';
        echo '<form method="post">';
        // Dodaj pola formularza, np. produkt, procent rabatu itp.
        echo '<input type="text" name="product_id" placeholder="ID Produktu">';
        echo '<input type="text" name="discount_percent" placeholder="Procent Rabatu">';
        echo '<input type="submit" name="submit" value="Dodaj Rabat">';
        echo '</form>';
        echo '</div>';
    }
}
