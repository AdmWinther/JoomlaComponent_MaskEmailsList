<?php

namespace Thusia\Component\MaskEmailsList\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Http\HttpFactory;
use Joomla\CMS\Log\Log;

class SiteinitialModel extends BaseDatabaseModel
{

    public function getMaskEmailsList() {


        $app = Factory::getApplication();
        $jinput = $app->input;

        try {
            // 1️⃣ Shared secret – must match backend
            //$secretKey = 'supersecretkey_you_store_in_env_or_config';

            // Get current user info
            $user = Factory::getUser();
            $username = $user->username;    // The username

            //Get email name from form

            $headers = [
                'Content-Type'  => 'application/json',
            ];

            // 5️⃣ Make HTTP POST to backend
            $http = HttpFactory::getHttp();
            $response = $http->get(
                'http://host.docker.internal:8080/simulate',  // Your backend endpoint
                $headers
            );

            // Log the result
            Log::add('Response: ' . $response->code . ' - ' . $response->body, Log::INFO, 'com_maskemailslist');

            // Optional: Handle success / failure
            if ($response->code >= 200 && $response->code < 300) {
                $app->enqueueMessage('Backend request succeeded. '. $response->body);
                Log::add('Backend request succeeded', Log::INFO, 'com_maskemailslist');
                return("This is my Data 200.");
            } else {
                $app->enqueueMessage('Backend error: ' . $response->body, 'error');
                Log::add('Backend request failed with code: ' . $response->code, Log::ERROR, 'com_maskemailslist');
                return("This is my Data Bad.");
            }

        } catch (Exception $e) {
            Log::add('Error in submit(): ' . $e->getMessage(), Log::ERROR, 'com_maskemailslist');
            $app->enqueueMessage('Error: ' . $e->getMessage(), 'error');
            return("ErrorData.");
        }
        return "Hello from Sarajevo.";
    }
}
