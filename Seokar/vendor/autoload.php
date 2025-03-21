spl_autoload_register(function ($class) {
    $base_dir = get_template_directory() . '/classes/';
    $class_file = $base_dir . 'class-' . strtolower(str_replace('_', '-', $class)) . '.php';

    if (file_exists($class_file)) {
        require_once $class_file;
    }
});
