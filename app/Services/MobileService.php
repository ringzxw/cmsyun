<?php
namespace App\Services;

use App\Exports\MobileImportErrorExport;
use App\Imports\MobilePoolImport;
use App\Models\MobileCompany;
use App\Models\MobileDetail;
use App\Models\MobileImport;
use App\Models\MobilePool;
use App\Models\MobileRoom;
use App\Utils\DateUtil;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MobileService extends BaseService
{
    /**
     * @throws \Exception
     */
    public function import()
    {
        $mobileImports = MobileImport::query()->where('status',MobileImport::STATUS_WAIT)->get();
        /** @var MobileImport $mobileImport */
        foreach ($mobileImports as $mobileImport)
        {
            $errors = array();
            $path = $mobileImport->file;
            $tables = Excel::toArray(new MobilePoolImport(), $path,'admin');
            if(count($tables) <= 0 || count($tables[0]) <= 1){
                continue;
            }
            $rows = $tables[0];
            unset($rows[0]);
            unset($rows[1]);
            $mobileAll = array();
            //导入客户
            DB::beginTransaction();
            foreach ($rows as $row) {
                if (empty($row[0]) && empty($row[1])) {
                    $row[] = '手机号和姓名都为空';
                    $errors[] = $row;
                    continue;
                }
                if (empty($row[1])) {
                    $row[] = '手机号为空';
                    $errors[] = $row;
                    continue;
                }
                if (!preg_match("/^1[345789]{1}\d{9}$/",$row[1])) {
                    $row[] = '手机号格式不正确';
                    $errors[] = $row;
                    continue;
                }
                if(in_array($row[1],$mobileAll)){
                    $row[] = '号码在此表格内有重复';
                    $errors[] = $row;
                    continue;
                }
                $mobileAll[] = $row[1];
                //通过验证 初始化相关数据
                static::_initMobilePool($mobileImport, $row);
                static::_initMobileDetail($row);
                static::_initMobileRoom($row);
                static::_initMobileCompany($row);
            }
            static::_initError($mobileImport, $errors);
            $mobileImport->status = MobileImport::STATUS_FINISH;
            $mobileImport->save();
            DB::commit();
        }
    }

    private function _initMobilePool(MobileImport $mobileImport, $row)
    {
        $mobilePool = new MobilePool();
        $mobilePool->name = $row[0] == null ? '' : trim($row[0]);
        $mobilePool->mobile = $row[1];
        $mobilePool->creator_id = $mobileImport->employee_id;
        $mobilePool->mobile_import_id = $mobileImport->id;
        $mobilePool->save();
    }

    private function _initError(MobileImport $mobileImport, $errors)
    {
        $upload_path = null;
        if(count($errors) > 0){
            $folder_name = "files/mobile/error/" . date("Ym", time()) . '/'.date("d", time());
            $filename = time() . '_' . str_random(10) . '.xlsx';
            $upload_path = $folder_name.$filename;
            Excel::store(new MobileImportErrorExport($errors,$mobileImport->title), $upload_path,'admin');
        }
        $mobileImport->error = $upload_path;
    }


    private function _initMobileDetail($row)
    {
        //验证手机号码详情
        $mobileDetail = MobileDetail::where('mobile', $row[1])->first();
        if(!$mobileDetail){
            $mobileDetail = new MobileDetail();
        }
        $mobileDetail->mobile           = $row[1];
        $mobileDetail->address          = $row[2]?:$mobileDetail->address;
        $mobileDetail->identity         = $row[3]?:$mobileDetail->identity;
        $mobileDetail->car              = $row[4]?:$mobileDetail->car;
        $mobileDetail->car_num          = $row[5]?:$mobileDetail->car_num;
        $mobileDetail->shop             = $row[12]?:$mobileDetail->shop;
        $mobileDetail->shop_address     = $row[13]?:$mobileDetail->shop_address;
        $mobileDetail->save();
    }

    private function _initMobileRoom($row)
    {
        if($row[6]){
            $mobileRoom = new MobileRoom();
            $mobileRoom->mobile             = $row[1];
            $mobileRoom->buy_room           = $row[6];
            $mobileRoom->buy_price          = $row[7];
            $mobileRoom->buy_time           = DateUtil::dayFormat($row[8]);
            $mobileRoom->save();
        }
    }

    private function _initMobileCompany($row)
    {
        if($row[9]){
            $mobileCompany = new MobileCompany();
            $mobileCompany->mobile           = $row[1];
            $mobileCompany->company          = $row[9];
            $mobileCompany->registered       = $row[10];
            $mobileCompany->registered_time  = DateUtil::dayFormat($row[11]);
            $mobileCompany->save();
        }
    }


}