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
        $input = $app->input;

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
            Log::add('fullUrl: ' . $fullUrl, Log::INFO, 'com_maskemailslist');

            // 5️⃣ Make HTTP POST to backend
            $http = HttpFactory::getHttp();
            $response = $http->get(
                $fullUrl,  // Your backend endpoint
                $headers
            );

            // Log the result
            Log::add('Response: ' . $response->code . ' - ' . $response->body, Log::INFO, 'com_maskemailslist');

            // Check if request was successful
            if ($response->code != 200) {
                Log::add('API Error: Response code ' . $response->code, Log::ERROR, 'com_maskemailslist');
                return [];
            }
            Log::add('$response->code: 200', Log::INFO, 'com_maskemailslist');
            // Parse JSON response
            $jsonData = json_decode($response->body, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::add('JSON Parse Error: ' . json_last_error_msg(), Log::ERROR, 'com_maskemailslist');
                return [];
            }

            // Extract the data we need
            $extractedData = [];

            if (isset($jsonData['data']) && is_array($jsonData['data'])) {
                foreach ($jsonData['data'] as $item) {
                    $extractedData[] = [
                        'id' => $item['id'] ?? '',
                        'name' => $item['attributes']['name'] ?? '',
                        'mask_email' => $item['attributes']['mask_email'] ?? '',
                        'account_id_c' => $item['attributes']['account_id_c'] ?? '',
                        'assignedtoaccount' => $item['attributes']['assignedtoaccount'] ?? ''
                    ];
                }
            }

            Log::add('Extracted ' . count($extractedData) . ' items', Log::INFO, 'com_maskemailslist');
            Log::add('Extracted data: ' . json_encode($extractedData), Log::DEBUG, 'com_maskemailslist');

            return $extractedData;

        } catch (Exception $e) {
            Log::add('Error in submit(): ' . $e->getMessage(), Log::ERROR, 'com_maskemailslist');
            $app->enqueueMessage('Error: ' . $e->getMessage(), 'error');
            return("ErrorData.");
        }
        return "Hello from Sarajevo.";
    }
}
