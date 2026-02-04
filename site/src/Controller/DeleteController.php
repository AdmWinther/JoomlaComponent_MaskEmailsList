<?php

namespace Thusia\Component\MaskEmailsList\Site\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Log\Log;
use Joomla\CMS\Factory;
use Joomla\CMS\Http\HttpFactory;


/**
 * @package     Joomla.Site
 * @subpackage  com_maskemailslist
 *
 * @copyright   Copyright (C) 2020 Adam Winther. All rights reserved.
 * @license     GNU General Public License version 3; see LICENSE
 */

/**
 * MaskEmailsList Component Controller
 * @since  0.0.2
 */
class DeleteController extends BaseController {
    /**
     * The default view for the display method.
     *
     * @var string
     */
    protected $default_view = 'siteinitial';

    private function loadConfig()
    {
        $configFile = JPATH_CONFIGURATION . '/components/com_maskemailslist/src/configuration/com_maskemailslistconfiguration.php';

        if (!file_exists($configFile)) {
            throw new \RuntimeException('Configuration file not found: ' . $configFile);
        }

        return require $configFile;
    }

    public function submit($account_id = null, $maskEmailId = null, $maskEmailAddress = null) {
        Log::add('Delete Mask email from account_id: ' . $account_id, Log::DEBUG, 'com_maskemailslist');
        Log::add('Mask Email ID is: ' . $maskEmailId, Log::DEBUG, 'com_maskemailslist');
        Log::add('and Mask Email Address is: ' . $maskEmailAddress, Log::DEBUG, 'com_maskemailslist');

        $app = Factory::getApplication();
        $input = $app->input;

        try {
            $config = $this->loadConfig();

            $backendUrl = $config['backend_url'];

            // 1️⃣ Shared secret – must match backend
            $secretKey = $config['secretKey'];

            $account_id = $input->getString('account_id');
            $maskEmailId = $input->getString('maskEmailId');

            $payload = [
                'account_id' => $account_id,
                'maskEmailId' => $maskEmailId,
                 'maskEmailAddress' => $maskEmailAddress
            ];

            $jsonPayload = json_encode($payload, JSON_UNESCAPED_SLASHES);
            Log::add('jsonPayload: ' . $jsonPayload , Log::DEBUG, 'com_maskemailslist');
            Log::add('$secretKey: ' . $secretKey , Log::DEBUG, 'com_maskemailslist');

            // 3️⃣ Create HMAC signature (hex encoded)
            $signature = hash_hmac('sha256', $jsonPayload, $secretKey);

            $headers = [
                'Content-Type'  => 'application/json',
                'X-Signature'   => $signature
            ];

            $requestParam = '?account_id='.$account_id."&maskEmailId=".$maskEmailId."&maskEmailAddress=".$maskEmailAddress;
            $fullUrl = $backendUrl . $requestParam;
            // 5️⃣ Make HTTP POST to backend
            $http = HttpFactory::getHttp();
            $response = $http->delete(
                $fullUrl,  // Your backend endpoint
                $headers
            );

            if ($response->code != 200) {
                Log::add('API Error: Response code ' . $response->code, Log::ERROR, 'com_maskemailslist');
                $app->redirect('index.php?option=com_maskemailslist&view=siteinitial');
            }

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::add('Failed to delete the mask email.' . json_last_error_msg(), Log::ERROR, 'com_maskemailslist');
                return [];
            }
            $app->redirect('index.php?option=com_maskemailslist&view=siteinitial');


        } catch (Exception $e) {
            Log::add('Error in Delete.submit(): ' . $e->getMessage(), Log::ERROR, 'com_maskemailslist');
            $app->enqueueMessage('Error: ' . $e->getMessage(), 'error');
            return("ErrorData.");
        }
    }
}