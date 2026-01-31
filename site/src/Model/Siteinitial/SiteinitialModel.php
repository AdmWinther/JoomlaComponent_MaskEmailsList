<?php

namespace Thusia\Component\MaskEmailsForm\Site\Model;

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