<?php

declare(strict_types=1);
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * @category        Module
 * @package         suico
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @author          Marcello Brandão aka  Suico, Mamba, LioMJ  <https://xoops.org>
 */

use Xmf\Request;
use XoopsModules\Suico\{
    IshotHandler
};

$GLOBALS['xoopsOption']['template_main'] = 'suico_index.tpl';
require __DIR__ . '/header.php';
/**
 * Factory of pictures created
 */
$ishotFactory = new IshotHandler($xoopsDB);
$uid_voted    = Request::getInt('uid_voted', 0, 'POST');
$ishot        = Request::getInt('ishot', 0, 'POST');
$uid_voter    = (int)$xoopsUser->getVar('uid');
if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_SUICO_TOKENEXPIRED);
}
/**
 * Verify if user is trying to vote for himself
 */
if ($uid_voter === $uid_voted) {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_SUICO_CANTVOTEOWN);
}
/**
 * Verify that this user hasn't voted or added this user yet
 */
$criteria_uidvoter = new Criteria(
    'uid_voter', $uid_voter
);
$criteria_uidvoted = new Criteria('uid_voted', $uid_voted);
$criteria          = new CriteriaCompo($criteria_uidvoter);
$criteria->add($criteria_uidvoted);
if (0 === $ishotFactory->getCount($criteria)) {
    $vote = $ishotFactory->create(true);
    $vote->setVar('uid_voted', $uid_voted);
    $vote->setVar('uid_voter', $uid_voter);
    if (1 === $ishot) {
        $vote->setVar('ishot', 1);
    } else {
        $vote->setVar('ishot', 0);
    }
    $ishotFactory->insert2($vote);
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_SUICO_VOTED);
} else {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_SUICO_ALREADYVOTED);
}
require dirname(__DIR__, 2) . '/footer.php';
