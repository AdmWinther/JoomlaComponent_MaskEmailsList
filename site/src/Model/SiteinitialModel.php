<?php

namespace Thusia\Component\MaskEmailsList\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Http\HttpFactory;
use Joomla\CMS\Log\Log;

class SiteinitialModel extends BaseDatabaseModel
{

    private function loadConfig()
    {
        $configFile = JPATH_CONFIGURATION . '/components/com_maskemailslist/src/configuration/com_maskemailslistconfiguration.php';

        if (!file_exists($configFile)) {
            throw new \RuntimeException('Configuration file not found: ' . $configFile);
        }

        return require $configFile;
    }

    public function getMaskEmailsList() {
        Log::addLogger(['text_file' => 'maskEmailsListsLogFile.log']);


        $app = Factory::getApplication();
        $jinput = $app->input;

        try {
            $config = $this->loadConfig();

            $backendUrl = $config['backend_url'];

            // 1️⃣ Shared secret – must match backend
            $secretKey = $config['secretKey'];



            // Get current user info
            $user = Factory::getUser();
            $username = $user->username;    // The username

            $payload = [
                'username' => $username
            ];

            $jsonPayload = json_encode($payload, JSON_UNESCAPED_SLASHES);
            Log::add('jsonPayload: ' . $jsonPayload , Log::INFO, 'com_maskemailslist');
            Log::add('$secretKey: ' . $secretKey , Log::INFO, 'com_maskemailslist');
            // 3️⃣ Create HMAC signature (hex encoded)
            $signature = hash_hmac('sha256', $jsonPayload, $secretKey);

            $headers = [
                'Content-Type'  => 'application/json',
                'X-Signature'   => $signature
            ];

            $requestParam = '?username='.$username;
            $fullUrl = $backendUrl . $requestParam;
            // 5️⃣ Make HTTP POST to backend
            $http = HttpFactory::getHttp();
            $response = $http->get(
                $fullUrl,  // Your backend endpoint
                $headers
            );

            // Log the result
            Log::add('Response: ' . $response->code . ' - ' . $response->body, Log::INFO, 'com_maskemailslist');

            // Optional: Handle success / failure
            if ($response->code >= 200 && $response->code < 300) {
                $app->enqueueMessage('Backend request succeeded. '. $response->body);
                Log::add('Backend request succeeded', Log::INFO, 'com_maskemailslist');
                return($response->body);
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
