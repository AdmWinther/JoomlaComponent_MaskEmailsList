<?php

namespace Thusia\Component\MaskEmailsList\Site\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Log\Log;


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
class DisplayController extends BaseController {
    /**
     * The default view for the display method.
     *
     * @var string
     */
    protected $default_view = 'siteinitial';
    
    public function display($account_id = null, $maskEmailId = null) {
        
        Log::addLogger(['text_file' => 'maskEmailsListsLogFile.log']);
        Log::add('Something happened in Display!', Log::INFO, 'com_maskemailslist');

        // For debugging
        // $someVariable = 'Hello World in Display';
        // echo '<pre>';
        // var_dump($someVariable);
        // echo '</pre>';
        // End debugging
        
        
        return parent::display($cachable, $urlparams);
    }
    
}