<?php

declare(strict_types=1);

/**
 * Extended User Profile
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       (c) 2000-2016 XOOPS Project (www.xoops.org)
 * @license             GNU GPL 2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package             profile
 * @since               2.3.0
 * @author              Taiwen Jiang <phppp@users.sourceforge.net>
 */

use XoopsModules\Suico\IndexController;
use Xmf\Request;

$GLOBALS['xoopsOption']['template_main'] = 'suico_email.tpl';
require __DIR__ . '/header.php';
/**
 * Fetching numbers of groups friends videos pictures etc...
 */
$controller = new IndexController($xoopsDB, $xoopsUser, $xoopsModule);
$nbSections = $controller->getNumbersSections();
/* @var XoopsConfigHandler $configHandler */
$configHandler              = xoops_getHandler('config');
$GLOBALS['xoopsConfigUser'] = $configHandler->getConfigsByCat(XOOPS_CONF_USER);
if (!$GLOBALS['xoopsUser'] || 1 != $GLOBALS['xoopsConfigUser']['allow_chgmail']) {
    redirect_header(XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname', 'n') . '/', 2, _NOPERM);
}
if (isset($_POST['submit'], $_POST['passwd'])) {
    $myts   = \MyTextSanitizer::getInstance();
    $pass   = Request::getString('passwd', '', 'POST');
    $email  = Request::getString('newmail', '', 'POST');
    $errors = [];
    if (!password_verify($oldpass, $GLOBALS['xoopsUser']->getVar('pass', 'n'))) {
        $errors[] = _MD_SUICO_WRONGPASSWORD;
    }
    if (!checkEmail($email)) {
        $errors[] = _US_INVALIDMAIL;
    }
    if ($errors) {
        $msg = implode('<br>', $errors);
    } else {
        //update password
        $GLOBALS['xoopsUser']->setVar('email', Request::getString('newmail', '', 'POST'));
        /* @var XoopsMemberHandler $memberHandler */
        $memberHandler = xoops_getHandler('member');
        if ($memberHandler->insertUser($GLOBALS['xoopsUser'])) {
            $msg = _MD_SUICO_EMAILCHANGED;
            //send email to new email address
            $xoopsMailer = xoops_getMailer();
            $xoopsMailer->useMail();
            $xoopsMailer->setTemplateDir($GLOBALS['xoopsModule']->getVar('dirname', 'n'));
            $xoopsMailer->setTemplate('emailchanged.tpl');
            $xoopsMailer->assign('SITENAME', $GLOBALS['xoopsConfig']['sitename']);
            $xoopsMailer->assign('ADMINMAIL', $GLOBALS['xoopsConfig']['adminmail']);
            $xoopsMailer->assign('SITEURL', XOOPS_URL . '/');
            $xoopsMailer->assign('NEWEMAIL', $email);
            $xoopsMailer->setToEmails($email);
            $xoopsMailer->setFromEmail($GLOBALS['xoopsConfig']['adminmail']);
            $xoopsMailer->setFromName($GLOBALS['xoopsConfig']['sitename']);
            $xoopsMailer->setSubject(sprintf(_MD_SUICO_NEWEMAIL, $GLOBALS['xoopsConfig']['sitename']));
            $xoopsMailer->send();
        } else {
            $msg = implode('<br>', $GLOBALS['xoopsUser']->getErrors());
        }
    }
    redirect_header(XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname', 'n') . '/index.php?uid=' . $GLOBALS['xoopsUser']->getVar('uid'), 2, $msg);
} else {
    //show change password form
    require_once $GLOBALS['xoops']->path('class/xoopsformloader.php');
    $form = new \XoopsThemeForm(_MD_SUICO_CHANGEMAIL, 'emailform', $_SERVER['REQUEST_URI'], 'post', true);
    $form->addElement(new \XoopsFormPassword(_US_PASSWORD, 'passwd', 15, 50), true);
    $form->addElement(new \XoopsFormText(_MD_SUICO_NEWMAIL, 'newmail', 15, 50), true);
    $form->addElement(new \XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
    $form->assign($GLOBALS['xoopsTpl']);
}
$xoopsOption['xoops_pagetitle'] = sprintf(_MD_SUICO_CHANGEMAIL, $xoopsModule->getVar('name'), $controller->nameOwner);
require __DIR__ . '/footer.php';
require dirname(__DIR__, 2) . '/footer.php';
