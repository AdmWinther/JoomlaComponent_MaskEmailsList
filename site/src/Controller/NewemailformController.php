<?php

namespace Thusia\Component\MaskEmailsForm\Site\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Factory;
use Joomla\CMS\Response\JsonResponse;
use Joomla\CMS\Log\Log;
use Joomla\CMS\Http\HttpFactory;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Router\Route;

class NewemailformController extends FormController 
{
    
    public function submit($newemail = null) {

        // For debugging
        Log::addLogger(['text_file' => 'maskEmailsFormLogFile.log']);
        Log::add('Submit method called in Newemailform Controller!', Log::INFO, 'com_maskemailsform');

        $app = Factory::getApplication();
        $jinput = $app->input;

        // Generate HMAC and send with the request
        try {
            // 1️⃣ Shared secret – must match backend
            $secretKey = 'supersecretkey_you_store_in_env_or_config';

            // Get current user info
            $user = Factory::getUser();
            $username = $user->username;    // The username

            //Get email name from form
            $name = $jinput->getString('name');

            // concat domain to email
            $newEmailAddress = $jinput->getString('newEmailAddress') . '@awin.dk';


            // 2️⃣ Data you want to send
            $payload = [
                'username' => $username,
                'name' => $name,
                'requestedEmail' => $newEmailAddress
            ];

            $jsonPayload = json_encode($payload, JSON_UNESCAPED_SLASHES);

            // 3️⃣ Create HMAC signature (hex encoded)
            $signature = hash_hmac('sha256', $jsonPayload, $secretKey);

            // 4️⃣ Prepare headers
            $headers = [
                'Content-Type'  => 'application/json',
                'X-Signature'   => $signature
            ];

            Log::add('Prepared payload: ' . $jsonPayload, Log::INFO, 'com_newemailform');
            Log::add('Prepared signature: ' . $signature, Log::INFO, 'com_newemailform');
            // 5️⃣ Make HTTP POST to backend
            $http = HttpFactory::getHttp();
            $response = $http->post(
                'https://api.awin.dk/newemailrequest',  // Your backend endpoint
                $jsonPayload,
                $headers
            );

            // Log the result
            Log::add('Response: ' . $response->code . ' - ' . $response->body, Log::INFO, 'com_newemailform');

            // Optional: Handle success / failure
            if ($response->code >= 200 && $response->code < 300) {
                $app->enqueueMessage('Backend request succeeded. '. $response->body);
                Log::add('Backend request succeeded', Log::INFO, 'com_newemailform');
            } else {
                $app->enqueueMessage('Backend error: ' . $response->body, 'error');
                Log::add('Backend request failed with code: ' . $response->code, Log::ERROR, 'com_newemailform');
            }

        } catch (Exception $e) {
            Log::add('Error in submit(): ' . $e->getMessage(), Log::ERROR, 'com_newemailform');
            $app->enqueueMessage('Error: ' . $e->getMessage(), 'error');
        }

        // Redirect back



        $app->redirect('index.php?option=com_maskemailsform&view=siteinitial');
    }
    
}