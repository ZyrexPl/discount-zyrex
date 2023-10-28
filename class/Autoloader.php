<?php // Autoloader.php
spl_autoload_register(function($class) {
    // Przestrzeń nazw twojej wtyczki
    $plugin_namespace = 'ZxDiscounts\\';
    // Ścieżka do katalogu, w którym znajdują się pliki klas
    $base_dir = plugin_dir_path(__FILE__);// . 'class/';

    // Jeśli przestrzeń nazw jest zgodna
    if (strpos($class, $plugin_namespace) === 0) {
        // Usuń przestrzeń nazw z nazwy klasy
        $class = substr($class, strlen($plugin_namespace));

        // Zmień znaki "\" na "/"
        $class = str_replace('\\', '/', $class);

        // Zbuduj ścieżkę do pliku klasy
        $file = $base_dir . $class . '.php';

        // Jeśli plik istnieje, załaduj go
        if (file_exists($file)) {
            require $file;
        }
    }
});
 ?>
