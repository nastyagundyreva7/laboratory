<?php
declare(strict_types=1);
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
return static function (RoutingConfigurator $routes): void {
    $routes->add('catalog_info', '/catalog-info')->controller([App\Controller\PageController::class, 'catalog'])->methods(['GET']);
};
