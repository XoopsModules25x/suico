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
 * @author              Jan Pedersen
 * @author              Taiwen Jiang <phppp@users.sourceforge.net>
 */


use XoopsModules\Suico\{
    Form\StepForm,
    Regstep,
    RegstepHandler
};

require_once __DIR__ . '/admin_header.php';
xoops_cp_header();
$adminObject->addItemButton(_AM_SUICO_STEP, 'registrationstep.php?op=new', 'add');
$adminObject->displayNavigation(basename(__FILE__));
$adminObject->displayButton('left');
$op      = $_REQUEST['op'] ?? (isset($_REQUEST['id']) ? 'edit' : 'list');
/** @var RegstepHandler $regstepHandler */
$regstepHandler = $helper->getHandler('Regstep');
switch ($op) {
    case 'list':
        $GLOBALS['xoopsTpl']->assign('steps', $regstepHandler->getObjects(null, true, false));
        $template_main = 'admin/suico_admin_registrationstep.tpl';
        break;
    case 'new':
        /** @var Regstep $obj */
        $obj  = $regstepHandler->create();
        $form = new StepForm($obj);
        $form->display();
        break;
    case 'edit':
        $obj  = $regstepHandler->get($_REQUEST['id']);
        $form = new StepForm($obj);
        $form->display();
        break;
    case 'save':
        if (isset($_REQUEST['id'])) {
            $obj = $regstepHandler->get($_REQUEST['id']);
        } else {
            $obj = $regstepHandler->create();
        }
        $obj->setVar('step_name', $_REQUEST['step_name']);
        $obj->setVar('step_order', $_REQUEST['step_order']);
        $obj->setVar('step_desc', $_REQUEST['step_desc']);
        $obj->setVar('step_save', $_REQUEST['step_save']);
        if ($regstepHandler->insert($obj)) {
            redirect_header('registrationstep.php', 3, sprintf(_AM_SUICO_SAVEDSUCCESS, _AM_SUICO_STEP));
        }
        echo $obj->getHtmlErrors();
        $form = $obj->getForm();
        $form->display();
        break;
    case 'delete':
        $obj = $regstepHandler->get($_REQUEST['id']);
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if ($regstepHandler->delete($obj)) {
                redirect_header('registrationstep.php', 3, sprintf(_AM_SUICO_DELETEDSUCCESS, _AM_SUICO_STEP));
            } else {
                echo $obj->getHtmlErrors();
            }
        } else {
            xoops_confirm(
                [
                    'ok' => 1,
                    'id' => $_REQUEST['id'],
                    'op' => 'delete',
                ],
                $_SERVER['REQUEST_URI'],
                sprintf(_AM_SUICO_RUSUREDEL, $obj->getVar('step_name'))
            );
        }
        break;
    case 'toggle':
        if (isset($_GET['step_id'])) {
            $field_id = (int)$_GET['step_id'];
            if (isset($_GET['step_save'])) {
                $step_save = (int)$_GET['step_save'];
                profile_stepsave_toggle($step_id, $step_save);
            }
        }
        break;
}
if (!empty($template_main)) {
    $GLOBALS['xoopsTpl']->display("db:{$template_main}");
}
/**
 * @param $step_d
 * @param $step_save
 */
function profile_stepsave_toggle($step_d, $step_save)
{
    $helper    = XoopsModules\Suico\Helper::getInstance();
    $step_save = (1 == $step_save) ? 0 : 1;
    $regstepHandler   = $helper->getHandler('Regstep');
    $obj       = $regstepHandler->get($_REQUEST['step_id']);
    $obj->setVar('step_save', $step_save);
    if ($regstepHandler->insert($obj, true)) {
        redirect_header('registrationstep.php', 1, _AM_SUICO_SAVESTEP_TOGGLE_SUCCESS);
    } else {
        redirect_header('registrationstep.php', 1, _AM_SUICO_SAVESTEP_TOGGLE_FAILED);
    }
}

require_once __DIR__ . '/admin_footer.php';
