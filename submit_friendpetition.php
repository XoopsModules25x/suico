<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author       Marcello Brandão aka  Suico
 * @author       XOOPS Development Team
 * @since
 */

use XoopsModules\Yogurt;

$GLOBALS['xoopsOption']['template_main'] = 'yogurt_index.tpl';
require __DIR__ . '/header.php';

/**
 * Modules class includes
 */
//require_once __DIR__ . '/class/Friendpetition.php';

/**
 * Factory of petitions created
 */
$friendpetitionFactory = new Yogurt\FriendpetitionHandler($xoopsDB);

/**
 * Getting the uid of the user which user want to ask to be friend
 */
$petitioned_uid = $_POST['petitioned_uid'];

/**
 * Verify Token
 */
if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(\Xmf\Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_YOGURT_TOKENEXPIRED);
}

//Verify if the user has already asked for friendship or if the user he s asking to be a friend has already asked him
$criteria = new \CriteriaCompo(new \Criteria('petioned_uid', $petitioned_uid));
$criteria->add(new \Criteria('petitioner_uid', $xoopsUser->getVar('uid')));
if ($friendpetitionFactory->getCount($criteria) > 0) {
    redirect_header(XOOPS_URL . '/modules/yogurt/index.php?uid=' . $_POST['petitioned_uid'], 3, _MD_YOGURT_ALREADY_PETITIONED);
} else {
    $criteria2 = new \CriteriaCompo(new \Criteria('petitioner_uid', $petitioned_uid));
    $criteria2->add(new \Criteria('petioned_uid', $xoopsUser->getVar('uid')));
    if ($friendpetitionFactory->getCount($criteria2) > 0) {
        redirect_header(XOOPS_URL . '/modules/yogurt/index.php?uid=' . $_POST['petitioned_uid'], 3, _MD_YOGURT_ALREADY_PETITIONED);
    }
}
/**
 * create the petition in database
 */
$newpetition = $friendpetitionFactory->create(true);
$newpetition->setVar('petitioner_uid', $xoopsUser->getVar('uid'));
$newpetition->setVar('petioned_uid', $_POST['petitioned_uid']);

if ($friendpetitionFactory->insert($newpetition)) {
    $extra_tags['X_OWNER_NAME'] = $xoopsUser->getVar('uname');
    $extra_tags['X_OWNER_UID']  = $xoopsUser->getVar('uid');
    $notificationHandler        = xoops_getHandler('notification');
    $notificationHandler->triggerEvent('friendship', $_POST['petitioned_uid'], 'new_friendship', $extra_tags);

    redirect_header(XOOPS_URL . '/modules/yogurt/index.php?uid=' . $_POST['petitioned_uid'], 3, _MD_YOGURT_PETITIONED);
} else {
    redirect_header(XOOPS_URL . '/modules/yogurt/index.php?uid=' . $xoopsUser->getVar('uid'), 3, _MD_YOGURT_NOCACHACA);
}

/**
 * Close page
 */
require dirname(dirname(__DIR__)) . '/footer.php';
