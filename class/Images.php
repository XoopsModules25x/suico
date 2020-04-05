<?php namespace XoopsModules\Yogurt;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * Module: Yogurt
 *
 * @category        Module
 * @package         yogurt
 * @author          XOOPS Development Team <https://xoops.org>
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GPL 2.0 or later
 * @link            https://xoops.org/
 * @since           1.0.0
 */

use XoopsModules\Yogurt;
use XoopsModules\Yogurt\Form;

//$permHelper = new \Xmf\Module\Helper\Permission();

/**
 * Class Images
 */
class Images extends \XoopsObject
{
    public $helper, $permHelper;

    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        parent::__construct();
        /** @var  Helper $helper */
        $this->helper     = Helper::getInstance();
        $this->permHelper = new \Xmf\Module\Helper\Permission();

        $this->initVar('cod_img', XOBJ_DTYPE_INT);
        $this->initVar('title', XOBJ_DTYPE_TXTBOX);
        $this->initVar('data_creation', XOBJ_DTYPE_DATE);
        $this->initVar('data_update', XOBJ_DTYPE_DATE);
        $this->initVar('uid_owner', XOBJ_DTYPE_TXTBOX);
        $this->initVar('url', XOBJ_DTYPE_OTHER);
        $this->initVar('private', XOBJ_DTYPE_TXTBOX);
    }

    /**
     * Get form
     *
     * @param null
     * @return Yogurt\Form\ImagesForm
     */
    public function getForm()
    {
        $form = new Form\ImagesForm($this);
        return $form;
    }

    /**
     * @return array|null
     */
    public function getGroupsRead()
    {
        //$permHelper = new \Xmf\Module\Helper\Permission();
        return $this->permHelper->getGroupsForItem('sbcolumns_read', $this->getVar('cod_img'));
    }

    /**
     * @return array|null
     */
    public function getGroupsSubmit()
    {
        //$permHelper = new \Xmf\Module\Helper\Permission();
        return $this->permHelper->getGroupsForItem('sbcolumns_submit', $this->getVar('cod_img'));
    }

    /**
     * @return array|null
     */
    public function getGroupsModeration()
    {
        //$permHelper = new \Xmf\Module\Helper\Permission();
        return $this->permHelper->getGroupsForItem('sbcolumns_moderation', $this->getVar('cod_img'));
    }
}

