<?php
/**
 * Created by PhpStorm.
 * User: zhuxiaowei
 * Date: 2018-12-13
 * Time: 10:43
 */

namespace App\Utils;


class ConstUtils
{
    /** 是否已读：是 */
    const READ_TRUE = 1;
    /** 是否已读：否 */
    const READ_FALSE = 0;

    /** BIZ类型：员工模块 */
    const BIZ_TYPE_EMPLOYEE         = 100;
    /** BIZ类型：项目模块 */
    const BIZ_TYPE_PROJECT          = 200;
    /** BIZ类型：客户模块 */
    const BIZ_TYPE_CUSTOMER         = 300;
    /** BIZ类型：号码模块 */
    const BIZ_TYPE_MOBILE_IMPORT    = 400;


    /** BIZ操作：号码导入成功 */
    const BIZ_ACTION_MOBILE_IMPORT_TRUE     = 400001;
    /** BIZ操作：号码导入失败 */
    const BIZ_ACTION_MOBILE_IMPORT_FALSE    = 400002;

}