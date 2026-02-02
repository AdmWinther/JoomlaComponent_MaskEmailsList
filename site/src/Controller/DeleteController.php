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
class DeleteController extends BaseController {
    /**
     * The default view for the display method.
     *
     * @var string
     */
    protected $default_view = 'siteinitial';

    public function submit($account_id = null, $maskEmailId = null) {
        die("something is here.");
        Log::add('Extracted data: ' . json_encode($extractedData), Log::DEBUG, 'com_maskemailslist');
        return parent::display($cachable, $urlparams);
    }

}