<!-- This is a special file that tells Joomla! how to initialise the component - which services it requires and how they should be provided.-->
<?php

defined('_JEXEC') or die;

use Joomla\CMS\Dispatcher\ComponentDispatcherFactoryInterface;
use Joomla\CMS\Extension\ComponentInterface;
use Joomla\CMS\Extension\MVCComponent;
use Joomla\CMS\Extension\Service\Provider\ComponentDispatcherFactory;
use Joomla\CMS\Extension\Service\Provider\MVCFactory;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

return new class implements ServiceProviderInterface {
    
    public function register(Container $container): void {

        // 1. Register the MVC Factory
        // This is the magic that auto-discovers and creates your Models, Views, and Controllers based on naming conventions:
        $container->registerServiceProvider(new MVCFactory('\\Thusia\\Component\\MaskEmailsList'));

        // 2. Register the Component Dispatcher Factory
        //      Receives the incoming request
        //      Determines which controller to use
        //      Routes the request to the appropriate controller
        $container->registerServiceProvider(new ComponentDispatcherFactory('\\Thusia\\Component\\MaskEmailsList'));

        // 3. Tell Joomla how to create your component
        // This tells Joomla: "When you need a ComponentInterface, here's how to build it":
        //      Create an MVCComponent instance
        //      Give it the dispatcher factory (for routing)
        //      Give it the MVC factory (for creating models/views/controllers)
        $container->set(
            ComponentInterface::class,
            function (Container $container) {
                $component = new MVCComponent($container->get(ComponentDispatcherFactoryInterface::class));
                $component->setMVCFactory($container->get(MVCFactoryInterface::class));

                return $component;
            }
        );
    }
};