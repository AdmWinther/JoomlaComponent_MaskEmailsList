<?php

namespace Thusia\Component\MaskEmailsList\Site\View\Siteinitial;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;

class HtmlView extends BaseHtmlView{

    protected $items;

    function display($tpl = null)
    {
        $this->items = $this->get('MaskEmailsList');

        // Check for errors (optional)
        if ($errors = $this->get('Errors')) {
            foreach ($errors as $error) {
                \Joomla\CMS\Factory::getApplication()->enqueueMessage($error, 'error');
            }
        }

        return parent::display($tpl);
    }
}