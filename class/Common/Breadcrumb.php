<?php

declare(strict_types=1);

namespace XoopsModules\Suico\Common;

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

/*
 * Example:
 * $breadcrumb = new Common\Breadcrumb();
 * $breadcrumb->addLink( 'bread 1', 'index1.php' );
 * $breadcrumb->addLink( 'bread 2', '' );
 * $breadcrumb->addLink( 'bread 3', 'index3.php' );
 * echo $breadcrumb->render();
 */

use XoopsModules\Suico;
use XoopsModules\Suico\Common;
use XoopsTpl;
use xos_opal_Theme;

/**
 * Class Breadcrumb
 */
class Breadcrumb
{
    public  $dirname;
    private $bread = [];

    public function __construct()
    {
        $this->dirname = \basename(\dirname(__DIR__, 2));
    }

    /**
     * Add link to breadcrumb
     *
     * @param string $title
     * @param string $link
     */
    public function addLink(
        $title = '',
        $link = ''
    ) {
        $this->bread[] = [
            'link'  => $link,
            'title' => $title,
        ];
    }

    /**
     * Render BreadCrumb
     */
    public function render()
    {
        if (!isset($GLOBALS['xoTheme']) || !\is_object($GLOBALS['xoTheme'])) {
            require $GLOBALS['xoops']->path('class/theme.php');
            $GLOBALS['xoTheme'] = new xos_opal_Theme();
        }
        require $GLOBALS['xoops']->path('class/template.php');
        $breadcrumbTpl = new \XoopsTpl();
        $breadcrumbTpl->assign('breadcrumb', $this->bread);
        $html = $breadcrumbTpl->fetch('db:' . $this->dirname . '_common_breadcrumb.tpl');
        unset($breadcrumbTpl);
        return $html;
    }
}
