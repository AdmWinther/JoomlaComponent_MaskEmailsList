<?php

namespace Thusia\Component\MaskEmailsList\Administrator\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;

/**
 * @package     Joomla.Site
 * @subpackage  com_maskemailslist
 *
 * @copyright   Copyright (C) 2020 Adam Winther. All rights reserved.
 * @license     GNU General Public License version 3; see LICENSE
 */

/**
 * NewEmailForm Component Controller
 * @since  0.0.2
 */
class DisplayController extends BaseController {
    /**
     * The default view for the display method.
     *
     * @var string
     */
    protected $default_view = 'adminstart';
    
    public function display($cachable = false, $urlparams = array()) {
        return parent::display($cachable, $urlparams);
    }
    
}