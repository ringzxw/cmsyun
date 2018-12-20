<?php
namespace App\Models\Traits;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\MobileImport;
use App\Models\Project;
use App\Utils\ConstUtils;

trait BizTrait
{

    /**
     * @param mixed $biz
     */
    public function setBiz($biz)
    {
        if (!$biz) {
            $this->biz_id = null;
            $this->biz_type = ConstUtils::BIZ_TYPE_SYSTEM;
        }
        if ($biz instanceof Employee) {
            $this->biz_id = $biz->id;
            $this->biz_type = ConstUtils::BIZ_TYPE_EMPLOYEE;
        }
        if ($biz instanceof Project) {
            $this->biz_id = $biz->id;
            $this->biz_type = ConstUtils::BIZ_TYPE_PROJECT;
        }
        if ($biz instanceof Customer) {
            $this->biz_id = $biz->id;
            $this->biz_type = ConstUtils::BIZ_TYPE_CUSTOMER;
        }
        if ($biz instanceof MobileImport) {
            $this->biz_id = $biz->id;
            $this->biz_type = ConstUtils::BIZ_TYPE_MOBILE_IMPORT;
        }
    }

}