<?php

use App\Controller\HomeController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes): void {
    // Дополнительный маршрут, объявленный через PHP-конфигурацию.
    $routes->add('about', '/about')
        ->controller([HomeController::class, 'about'])
        ->methods(['GET']);
};
