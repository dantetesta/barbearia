<?php
/**
 * Don Barbero - Bootstrap da Aplicação
 * 
 * @author Dante Testa <https://dantetesta.com.br>
 * @created 03/11/2025 15:34
 * @version 1.0.0
 */

declare(strict_types=1);

// Carregar configurações
$config = require_once __DIR__ . '/config.php';

// Autoloader simples PSR-4
spl_autoload_register(function ($class) {
    $prefix = '';
    $baseDir = __DIR__ . '/../app/';
    
    // Remover o prefixo se houver
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // Não é da nossa namespace, deixar outros autoloaders tentarem
        $file = $baseDir . str_replace('\\', '/', $class) . '.php';
    } else {
        // Remover o prefixo
        $relativeClass = substr($class, $len);
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    }
    
    // Se o arquivo existir, carregá-lo
    if (file_exists($file)) {
        require_once $file;
        return true;
    }
    
    return false;
});

// Carregar helpers globais
require_once __DIR__ . '/helpers.php';

// Carregar o router
require_once __DIR__ . '/router.php';

// Criar instância do router e processar a request
$router = new Router();

// Registrar rotas
require_once __DIR__ . '/routes.php';

// Despachar a request
$router->dispatch();
