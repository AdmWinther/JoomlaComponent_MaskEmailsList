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
        $container->registerServiceProvider(new MVCFactory('\\Thusia\\Component\\MaskEmailsList'));
        $container->registerServiceProvider(new ComponentDispatcherFactory('\\Thusia\\Component\\MaskEmailsList'));
        $container->set(
            ComponentInterface::class,
            function (Container $container) {
                $component = new MVCComponent($container->get(ComponentDispatcherFactoryInterface::class));
                $component->setMVCFactory($container->get(MVCFactoryInterface::class));

                return $component;
            }
        );

        $container->set(
            NewEmailFormController::class,
            function (Container $container) {
                return new NewEmailFormController([
                    'name' => 'newemailform',
                    'option' => 'com_maskemailsform',
                ]);
            }
        );
    }
};