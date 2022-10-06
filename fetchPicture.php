<?php declare(strict_types=1);
if (!defined('XOOPS_MAINFILE_INCLUDED')) {
    require_once \dirname(__DIR__) . '/mainfile.php';
}
$xoopsLogger->activated = false;
if (isset($_POST['cod_img'])) {
    $xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();
    $sql     = 'SELECT * FROM ' . $xoopsDB->prefix('suico_images') . ' WHERE cod_img=' . $_POST['cod_img'] . "'";
    //    $sql = "SELECT * FROM tbl_employee WHERE id = '" . $_POST['employee_id'] . "'";
    if (!$result = $xoopsDB->queryF($sql)) {
        return false;
    }
    $row      = $xoopsDB->fetchArray($result);
    $jencoded = json_encode($row);
    echo $jencoded;
}
