<?php declare(strict_types=1);

//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <https://www.xoops.org>                             //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

use Xmf\Request;

$GLOBALS['xoopsOption']['template_main'] = 'yogurt_user.tpl';
require __DIR__ . '/header.php';

/**
 * If is user redirects to own profile
 */

if (($xoopsUser)) {
   $isAnonym = 0;
		if (isset($_GET['uid'])) {
			$uid_owner = Request::getInt('uid', 0, 'GET');
			$isOwner   = $xoopsUser->getVar('uid') === $uid_owner ? 1 : 0;
		} else {
			$uid_owner = (int)$xoopsUser->getVar('uid');
			$isOwner   = 1;
		}
redirect_header('' . XOOPS_URL . "/modules/yogurt/index.php?uid=$uid_owner");
}


require_once XOOPS_ROOT_PATH . '/footer.php';
