<?php declare(strict_types=1);

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

use Xmf\Request;
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
$petitionfrom_uid = $_POST['petitionfrom_uid'];

if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_YOGURT_TOKENEXPIRED);
}

//Verify if the user has already asked for friendship or if the user he s asking to be a friend has already asked him
$criteria = new CriteriaCompo(
    new Criteria(
        'petitionto_uid', $petitionfrom_uid
    )
);
$criteria->add(new Criteria('petitioner_uid', $xoopsUser->getVar('uid')));
if ($friendpetitionFactory->getCount($criteria) > 0) {
    redirect_header(
        XOOPS_URL . '/modules/yogurt/index.php?uid=' . Request::getInt('petitionfrom_uid', 0, 'POST'), 3, _MD_YOGURT_ALREADY_PETITIONFROM);
} else {
    $criteria2 = new CriteriaCompo(new Criteria('petitioner_uid', $petitionfrom_uid));
    $criteria2->add(new Criteria('petitionto_uid', $xoopsUser->getVar('uid')));
    if ($friendpetitionFactory->getCount($criteria2) > 0) {
        redirect_header(
            XOOPS_URL . '/modules/yogurt/index.php?uid=' . Request::getInt('petitionfrom_uid', 0, 'POST'), 3, _MD_YOGURT_ALREADY_PETITIONFROM);
    }
}
/**
 * create the petition in database
 */
$newpetition = $friendpetitionFactory->create(true);
$newpetition->setVar('petitioner_uid', $xoopsUser->getVar('uid'));
$newpetition->setVar('petitionto_uid', Request::getInt('petitionfrom_uid', 0, 'POST'));

if ($friendpetitionFactory->insert2($newpetition)) {
    $extra_tags['X_OWNER_NAME'] = $xoopsUser->getVar('uname');
    $extra_tags['X_OWNER_UID']  = $xoopsUser->getVar('uid');
    $notificationHandler        = xoops_getHandler('notification');
    $notificationHandler->triggerEvent('friendship', Request::getInt('petitionfrom_uid', 0, 'POST'), 'new_friendship', $extra_tags);

    redirect_header(
        XOOPS_URL . '/modules/yogurt/index.php?uid=' . Request::getInt('petitionfrom_uid', 0, 'POST'), 3, _MD_YOGURT_PETITIONFROM);
} else {
    redirect_header(
        XOOPS_URL . '/modules/yogurt/index.php?uid=' . $xoopsUser->getVar('uid'),
        3,
        _MD_YOGURT_NOCACHACA
    );
}

/**
 * Close page
 */
require dirname(dirname(__DIR__)) . '/footer.php';
