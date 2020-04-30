<?php

declare(strict_types=1);

namespace XoopsModules\Suico;

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

use XoopsModules\Suico;

//$permHelper = new \Xmf\Module\Helper\Permission();

/**
 * Class Privacy
 */
class Privacy extends \XoopsObject
{
    public $helper;
    public $permHelper;

    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        parent::__construct();
        //        /** @var  Suico\Helper $helper */
        //        $this->helper = Suico\Helper::getInstance();
        $this->permHelper = new \Xmf\Module\Helper\Permission();
        $this->initVar('id', \XOBJ_DTYPE_INT);
        $this->initVar('level', \XOBJ_DTYPE_INT);
        $this->initVar('name', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('description', \XOBJ_DTYPE_OTHER);
    }

    /**
     * Get form
     *
     * @param null
     * @return Suico\Form\PrivacyForm
     */
    public function getForm()
    {
        $form = new Form\PrivacyForm($this);
        return $form;
    }

    /**
     * @return array|null
     */
    public function getGroupsRead()
    {
        //$permHelper = new \Xmf\Module\Helper\Permission();
        return $this->permHelper->getGroupsForItem('sbcolumns_read', $this->getVar('id'));
    }

    /**
     * @return array|null
     */
    public function getGroupsSubmit()
    {
        //$permHelper = new \Xmf\Module\Helper\Permission();
        return $this->permHelper->getGroupsForItem('sbcolumns_submit', $this->getVar('id'));
    }

    /**
     * @return array|null
     */
    public function getGroupsModeration()
    {
        //$permHelper = new \Xmf\Module\Helper\Permission();
        return $this->permHelper->getGroupsForItem('sbcolumns_moderation', $this->getVar('id'));
    }
}
