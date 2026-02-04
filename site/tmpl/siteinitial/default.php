<?php
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Session\Session;
?>

<div class="mask-emails-list">
    <h1><?= Text::_('Mask Emails List') ?></h1>

    <?php if (empty($this->items)): ?>
        <div class="alert alert-info">
            <p><?= Text::_('COM_MASKEMAILSLIST_NO_ITEMS') ?></p>
        </div>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Mask Email</th>
                    <th>Assigned To</th>
                    <th>Account ID</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= htmlspecialchars($item['mask_email']) ?></td>
                        <td><?= htmlspecialchars($item['assignedtoaccount']) ?></td>
                        <td><small><?= htmlspecialchars($item['account_id_c']) ?></small></td>
                        <td class="text-center">
                            <form method="post" action="index.php?option=com_maskemailslist&task=delete.submit" style="display:inline;">
                                <input type="hidden" name="account_id" value="<?= htmlspecialchars($item['account_id_c']) ?>">
                                <input type="hidden" name="maskEmailId" value="<?= htmlspecialchars($item['id']) ?>">
                                <input type="hidden" name="maskEmailAddress" value="<?= htmlspecialchars($item['mask_email']) ?>">
                                <input type="hidden" name="<?= Session::getFormToken() ?>" value="1">
                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete <?= htmlspecialchars($item['mask_email']) ?>?');"
                                >
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>