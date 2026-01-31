<?php
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_maskemailslist
 *
 * @copyright   Copyright (C) 2020 Adam Winther. All rights reserved.
 * @license     GNU General Public License version 3; see LICENSE
 */

// Prevent direct access
defined('_JEXEC') or die;

// Assume $this->message is set in the view
?>

<div>
    <h1>New email form</h1>
    <p>This is first</p>
    <p>This is second</p>
    <p>This is third</p>
    <p><?php echo $this->maskemailslist; ?></p>
    <p><?php echo $this->original; ?></p>

</div>