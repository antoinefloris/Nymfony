<?php
namespace Helper;

/**
 * Class Majordomo
 * @package Helper
 * @author Yann Le Scouarnec <yann.le-scouarnec@hetic.net>
 */
class Majordomo
{
    /**
     * Outputs current configuration
     */
    public static function config()
    {
        $configOutput = '[App Configuration]' . PHP_EOL;
        $constants = get_defined_constants(true);
        foreach ($constants['user'] as $constantName => $constantValue) {
            $configOutput .= $constantName . ' = ' . $constantValue . PHP_EOL;
        }
        CLIShellColor::commandOutput($configOutput.PHP_EOL, 'white', 'green');
    }

    /**
     * Outputs router debug information
     */
    public static function router()
    {
        $routerOutput = '[Router]' . PHP_EOL;
        Router::init();
        $routes = Router::dump();
        $routerOutput .= CLITableBuilder::init(
            $routes,
            ['identifier', 'name', 'controller', 'action', 'method'],
            false,
            10
        );
        CLIShellColor::commandOutput($routerOutput.PHP_EOL, 'white', 'green');
    }

    /**
     * Outputs container debug information
     */
    public static function container()
    {
        $containerOutput = '[ServiceContainer]' . PHP_EOL;
        ServiceContainer::init();
        $services = ServiceContainer::getServiceCollection();
        $serviceDebug = [];
        foreach ($services as $name => $service) {
            $serviceDebug[] = [
                'name' => $name,
                'class' => get_class($service),
            ];
        }
        $containerOutput .= CLITableBuilder::init(
            $serviceDebug,
            ['Name', 'Class'],
            false,
            10
        );
        CLIShellColor::commandOutput($containerOutput.PHP_EOL, 'white', 'green');
    }
}
