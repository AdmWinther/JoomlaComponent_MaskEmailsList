<?php

namespace Thusia\Component\MaskEmailsList\Site\View\Siteinitial;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;

class HtmlView extends BaseHtmlView{

    protected $maskemailslist;
    protected $original;

    function display($tpl = null)
    {

        // When you run the following command, Joomla's HtmlView class (which this view extends) has a magic get() method that:
        //      Takes the string 'MaskEmailsList'
        //      Prepends 'get' to it → becomes 'getMaskEmailsList'
        //      Calls $model->getMaskEmailsList() on the model which we already have in SiteinitialModel.php
        // Alternatively we could go the long way:
        //      Get the model explicitly
        //      $model = $this->getModel();
        //      // Call the method directly
        //      $this->data = $model->getMaskEmailsList();
        $this->original = $this->get('MaskEmailsList');
        $this->maskemailslist = "Kashkakww";

        // Call the parent's display method, the parent is BaseHtmlView which we are extending in this class.
        parent::display($tpl);
    }
}