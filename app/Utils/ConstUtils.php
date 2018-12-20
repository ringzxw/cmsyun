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


    /** BIZ类型：系统 */
    const BIZ_TYPE_SYSTEM   = 1001;
    /** BIZ类型：员工 */
    const BIZ_TYPE_EMPLOYEE = 1002;
    /** BIZ类型：项目 */
    const BIZ_TYPE_PROJECT  = 1003;
    /** BIZ类型：客户 */
    const BIZ_TYPE_CUSTOMER = 1004;
    /** BIZ类型：号码导入 */
    const BIZ_TYPE_MOBILE_IMPORT = 1005;
    /** BIZ操作：号码导入成功 */
    const BIZ_ACTION_MOBILE_IMPORT_TRUE = 1005001;
    /** BIZ操作：号码导入失败 */
    const BIZ_ACTION_MOBILE_IMPORT_FALSE = 1005002;


}