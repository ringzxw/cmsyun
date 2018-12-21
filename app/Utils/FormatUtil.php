<?php
/**
 * Created by PhpStorm.
 * User: zhuxiaowei
 * Date: 2017/8/8
 * Time: 下午9:40
 */

namespace App\Utils;

use App\Models\Base;
use App\Models\Customer;
use App\Models\CustomerSuccess;
use App\Models\MobilePool;

class FormatUtil
{
    /**
     * 操作类型对应的模块
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getBizType($val, $default = '')
    {
        $map= [
            ConstUtils::BIZ_TYPE_EMPLOYEE           => '员工模块',
            ConstUtils::BIZ_TYPE_PROJECT            => '项目模块',
            ConstUtils::BIZ_TYPE_CUSTOMER           => '客户模块',
            ConstUtils::BIZ_TYPE_MOBILE_IMPORT      => '号码模块',
        ];
        if (array_key_exists($val, $map)) {
            return $map[$val];
        }
        return $default;
    }


    /**
     * 操作类型对于的icon
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getBizActionIcon($val, $default = '')
    {
        $map= [
            ConstUtils::BIZ_ACTION_MOBILE_IMPORT_TRUE       => 'fa-check text-green',
            ConstUtils::BIZ_ACTION_MOBILE_IMPORT_FALSE      => 'fa-warning text-yellow',
        ];
        if (array_key_exists($val, $map)) {
            return $map[$val];
        }
        return $default;
    }

    /**
     * 是否类型
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getIs($val, $default = '')
    {
        $options = OptionUtil::getIsOption();
        if($val && $options->has($val)){
            return $options->get($val);
        }
        return $default;
    }

    /**
     * 奖金审核类型
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getBonusType($val, $default = '')
    {
        $options = OptionUtil::getBonusTypeOption();
        if($val && $options->has($val)){
            return $options->get($val);
        }
        return $default;
    }

    /**
     * 审核状态类型
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getAuditStatus($val, $default = '审核中')
    {
        $map= [
            Base::IS_FALSE     => "拒绝",
            Base::IS_TRUE      => "通过",
        ];
        if (array_key_exists($val, $map)) {
            return $map[$val];
        }
        return $default;
    }


    /**
     * 日志类型
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getLogType($val, $default = '')
    {
        $map= [
            Base::LOG_TYPE_MEET     => "约访",
            Base::LOG_TYPE_COME     => "来访",
            Base::LOG_TYPE_SUCCESS  => "成交",
        ];
        if (array_key_exists($val, $map)) {
            return $map[$val];
        }
        return $default;
    }

    /**
     * 获取导入状态
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getImportLogStatus($val, $default = '')
    {
        if (array_key_exists($val, static::$importLogStatusMapping)) {
            return static::$importLogStatusMapping[$val];
        }
        return $default;
    }

    private static $importLogStatusMapping = [
        Base::IMPORT_TRUE => "<span class='label label-success'>已导入</span>",
        Base::IMPORT_FALSE => "<span class='label label-warning'>未导入</span>",
    ];

    /**
     * 是否关闭
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getCloseStatus($val, $default = '')
    {
        $map= [
            Base::CLOSE_TRUE  => "<span class='label label-success'>是</span>",
            Base::CLOSE_FALSE => "<span class='label label-warning'>否</span>",
        ];
        if (array_key_exists($val, $map)) {
            return $map[$val];
        }
        return $default;
    }

    /**
     * 获取意向区域
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getIntentionRegion($val, $default = '')
    {
        $options = OptionUtil::getIntentionRegionOption();
        if($val && $options->has($val)){
            return $options->get($val);
        }
        return $default;
    }

    /**
     * 获取意向面积
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getIntentionArea($val, $default = '')
    {
        $options = OptionUtil::getIntentionAreaOption();
        if($val && $options->has($val)){
            return $options->get($val);
        }
        return $default;
    }

    /**
     * 获取意向类别
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getIntentionType($val, $default = '')
    {
        $options = OptionUtil::getIntentionTypeOption();
        if($val && $options->has($val)){
            return $options->get($val);
        }
        return $default;
    }

    /**
     * 获取意向总价
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getIntentionTotal($val, $default = '')
    {
        $options = OptionUtil::getIntentionTotalOption();
        if($val && $options->has($val)){
            return $options->get($val);
        }
        return $default;
    }

    /**
     * 获取意向单价
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getIntentionPrice($val, $default = '')
    {
        $options = OptionUtil::getIntentionPriceOption();
        if($val && $options->has($val)){
            return $options->get($val);
        }
        return $default;
    }

    /**
     * 获取性别
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getGender($val,$default='')
    {
        $options = OptionUtil::getIntentionRegionOption();
        if($options->has($val)){
            return $options->get($val);
        }
        return $default;
    }

    /**
     * 获取是否添加
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getAdd($val, $default = '未添加')
    {
        $map = [
            Base::ADD_TRUE => '已添加',
            Base::ADD_FALSE => '未添加',
        ];
        if (array_key_exists($val, $map)) {
            return $map[$val];
        }
        return $default;
    }

    /**
     * 获取提醒类型
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getRemindType($val, $default = '')
    {
        $map = [
            Base::REMIND_TYPE_OUT => '客户过期提醒',
            Base::REMIND_TYPE_LOG => '下次约访提醒',
        ];
        if (array_key_exists($val, $map)) {
            return $map[$val];
        }
        return $default;
    }


    /**
     * 获取意向等级样式
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getLabelCss($val, $default = '')
    {
        $isLabelCssMapping = [
            Customer::LABEL_S => 'bg-fuchsia',
            Customer::LABEL_A => 'bg-red',
            Customer::LABEL_B => 'bg-purple',
            Customer::LABEL_C => 'bg-orange',
            Customer::LABEL_D => 'bg-green',
            Customer::LABEL_E => 'bg-blue',
        ];
        if (array_key_exists($val, $isLabelCssMapping)) {
            return $isLabelCssMapping[$val];
        }
        return $default;
    }


    /**
     * 获取意向等级文字
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getLabelHtml($val, $default = '')
    {
        $isLabelHtmlMapping = [
            Customer::LABEL_S => '<span class="badge '.static::getLabelCss($val).'">S</span>',
            Customer::LABEL_A => '<span class="badge '.static::getLabelCss($val).'">A</span>',
            Customer::LABEL_B => '<span class="badge '.static::getLabelCss($val).'">B</span>',
            Customer::LABEL_C => '<span class="badge '.static::getLabelCss($val).'">C</span>',
            Customer::LABEL_D => '<span class="badge '.static::getLabelCss($val).'">D</span>',
            Customer::LABEL_E => '<span class="badge '.static::getLabelCss($val).'">E</span>',
        ];
        if (array_key_exists($val,$isLabelHtmlMapping)) {
            return $isLabelHtmlMapping[$val];
        }
        return $default;
    }

    /**
     * 获取意向等级文字
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getLabel($val, $default = '')
    {
        $isMapping = [
            Customer::LABEL_S => 'S',
            Customer::LABEL_A => 'A',
            Customer::LABEL_B => 'B',
            Customer::LABEL_C => 'C',
            Customer::LABEL_D => 'D',
            Customer::LABEL_E => 'E',
        ];
        if (array_key_exists($val,$isMapping)) {
            return $isMapping[$val];
        }
        return $default;
    }

    /**
     * 获取意向等级样式
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getCustomerStatusCss($val, $default = '')
    {
        $isStatusCssMapping = [
            Customer::STATUS_WAIT_MEET => 'bg-orange',
            Customer::STATUS_WAIT_ALLOT => 'bg-red',
            Customer::STATUS_MEET => 'bg-blue',
            Customer::STATUS_SUCCESS => 'bg-green',
            Customer::STATUS_END => 'bg-gray',
            Customer::STATUS_COME => 'bg-purple',
            Customer::STATUS_REAL => 'bg-aqua',
        ];
        if (array_key_exists($val, $isStatusCssMapping)) {
            return $isStatusCssMapping[$val];
        }
        return $default;
    }

    /**
     * 获取成交状态样式
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getCustomerSuccessStatusCss($val, $default = '')
    {
        $isStatusCssMapping = [
            CustomerSuccess::STATUS_BUY => 'bg-orange',
            CustomerSuccess::STATUS_LOSE => 'bg-red',
            CustomerSuccess::STATUS_SIGN => 'bg-blue',
            CustomerSuccess::STATUS_WAIT => 'bg-green',
            CustomerSuccess::STATUS_END => 'bg-gray',
        ];
        if (array_key_exists($val, $isStatusCssMapping)) {
            return $isStatusCssMapping[$val];
        }
        return $default;
    }

    /**
     * 获取客户意向等级样式
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getCustomerStatusHtml($val, $default = '')
    {
        $isCustomerStatusHtmlMapping = [
            Customer::STATUS_WAIT_MEET     =>  '<span class="badge '.static::getCustomerStatusCss($val).'">待约访</span>',
            Customer::STATUS_WAIT_ALLOT    =>  '<span class="badge '.static::getCustomerStatusCss($val).'">待分配</span>',
            Customer::STATUS_MEET          =>  '<span class="badge '.static::getCustomerStatusCss($val).'">约访中</span>',
            Customer::STATUS_SUCCESS       =>  '<span class="badge '.static::getCustomerStatusCss($val).'">成交</span>',
            Customer::STATUS_END           =>  '<span class="badge '.static::getCustomerStatusCss($val).'">无效</span>',
            Customer::STATUS_COME          =>  '<span class="badge '.static::getCustomerStatusCss($val).'">来访</span>',
            Customer::STATUS_REAL          =>  '<span class="badge '.static::getCustomerStatusCss($val).'">认筹</span>',
        ];
        if (array_key_exists($val,$isCustomerStatusHtmlMapping)) {
            return $isCustomerStatusHtmlMapping[$val];
        }
        return $default;
    }

    /**
     * 获取意向等级样式
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getCustomerSuccessStatusHtml($val, $default = '')
    {
        $isMapping = [
            CustomerSuccess::STATUS_BUY         =>  '<span class="badge '.static::getCustomerSuccessStatusCss($val).'">认购</span>',
            CustomerSuccess::STATUS_SIGN        =>  '<span class="badge '.static::getCustomerSuccessStatusCss($val).'">签约</span>',
            CustomerSuccess::STATUS_LOSE        =>  '<span class="badge '.static::getCustomerSuccessStatusCss($val).'">缺件</span>',
            CustomerSuccess::STATUS_WAIT        =>  '<span class="badge '.static::getCustomerSuccessStatusCss($val).'">待放款</span>',
            CustomerSuccess::STATUS_END         =>  '<span class="badge '.static::getCustomerSuccessStatusCss($val).'">完结</span>',
        ];
        if (array_key_exists($val,$isMapping)) {
            return $isMapping[$val];
        }
        return $default;
    }

    /**
     * 获取客户状态
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getCustomerStatus($val, $default = '')
    {
        $isMapping = [
            Customer::STATUS_WAIT_MEET     =>  '待约',
            Customer::STATUS_WAIT_ALLOT    =>  '分配',
            Customer::STATUS_MEET          =>  '约访',
            Customer::STATUS_SUCCESS       =>  '成交',
            Customer::STATUS_END           =>  '无效',
            Customer::STATUS_COME          =>  '来访',
            Customer::STATUS_REAL          =>  '认筹',
        ];
        if (array_key_exists($val,$isMapping)) {
            return $isMapping[$val];
        }
        return $default;
    }

    /**
     * 是否是团队管理员
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getTeamAdmin($val, $default = '')
    {
        $map= [
            Base::TEAM_ADMIN_TRUE => "<span class='label label-success'>是</span>",
            Base::TEAM_ADMIN_FALSE => "<span class='label label-warning'>否</span>",
        ];
        if (array_key_exists($val, $map)) {
            return $map[$val];
        }
        return $default;
    }

    /**
     * 获取标签类型样式
     * @param $val
     * @param string $default
     * @return mixed|string
     */
    public static function getTagTypeHtml($val, $default = '')
    {
        $isMapping = [
            Base::TAG_TYPE_PROJECT              =>  '<span class="badge bg-danger">项目标签</span>',
            Base::TAG_TYPE_SUBJECT              =>  '<span class="badge bg-purple">产品标签</span>',
            Base::TAG_TYPE_EMPLOYEE             =>  '<span class="badge bg-orange">员工标签</span>',
            Base::TAG_TYPE_CUSTOMER             =>  '<span class="badge bg-green">客户标签</span>',

        ];
        if (array_key_exists($val,$isMapping)) {
            return $isMapping[$val];
        }
        return $default;
    }

    /**
     * 随机颜色
     * @return mixed|string
     */
    public static function getRandomColor()
    {
        $colorArray = array('success','warning','danger','info','primary','default');
        return $colorArray[rand(0,5)];
    }


    /**
     * @param $val
     * @param null $default
     * @return mixed|null
     */
    public static function getLabels($val, $default = '')
    {
        $isMapping = [
            'S'=>Customer::LABEL_S,
            'A'=>Customer::LABEL_A,
            'B'=>Customer::LABEL_B,
            'C'=>Customer::LABEL_C,
            'D'=>Customer::LABEL_D,
            'E'=>Customer::LABEL_E,
            'F'=>Customer::LABEL_F,
        ];
        if (array_key_exists($val,$isMapping)) {
            return $isMapping[$val];
        }
        return $default;
    }

    /**
     * @param $val
     * @param null $default
     * @return mixed|null
     */
    public static function getWxStatus($val, $default = '')
    {
        $isMapping = [
            '已添加'=>Base::ADD_TRUE,
            '未添加'=>Base::ADD_FALSE,
        ];
        if (array_key_exists($val,$isMapping)) {
            return $isMapping[$val];
        }
        return $default;
    }


    /**
     * 决策权
     * @param $val
     * @param null $default
     * @return mixed|null
     */
    public static function getCustomerManager($val, $default = '')
    {
        $options = OptionUtil::getCustomerManagerOption();
        if($val && $options->has($val)){
            return $options->get($val);
        }
        return $default;
    }

    /**
     * 购买用途
     * @param $val
     * @param null $default
     * @return mixed|null
     */
    public static function getCustomerBuyType($val, $default = '')
    {
        $options = OptionUtil::getBuyTypeOption();
        if($val && $options->has($val)){
            return $options->get($val);
        }
        return $default;
    }

    public static function getIncomeText($val, $default = '')
    {
        $options = OptionUtil::getIncomeOption();
        if($val && $options->has($val)){
            return $options->get($val);
        }
        return $default;
    }

    public static function getIndustryText($val, $default = '')
    {
        $options = OptionUtil::getIndustryOption();
        if($val && $options->has($val)){
            return $options->get($val);
        }
        return $default;
    }

    public static function getJobText($val, $default = '')
    {
        $options = OptionUtil::getJobOption();
        if($val && $options->has($val)){
            return $options->get($val);
        }
        return $default;
    }

    public static function getBuyHouseText($val, $default = '')
    {
        $options = OptionUtil::getBuyHouseOption();
        if($val && $options->has($val)){
            return $options->get($val);
        }
        return $default;
    }

    public static function getFinancialText($val, $default = '')
    {
        $options = OptionUtil::getFinancialOption();
        if($val && $options->has($val)){
            return $options->get($val);
        }
        return $default;
    }

    public static function getIntroduceText($val, $default = '')
    {
        $options = OptionUtil::getIntroduceOption();
        if($val && $options->has($val)){
            return $options->get($val);
        }
        return $default;
    }

    public static function getChannelText($val, $default = '')
    {
        $options = OptionUtil::getChannelOption();
        if($val && $options->has($val)){
            return $options->get($val);
        }
        return $default;
    }

    public static function getAgeText($val, $default = '')
    {
        $options = OptionUtil::getAgeOption();
        if($val && $options->has($val)){
            return $options->get($val);
        }
        return $default;
    }


    public static function getHouseOldText($val, $default = '')
    {
        $options = OptionUtil::getHouseOption();
        if($val && $options->has($val)){
            return $options->get($val);
        }
        return $default;
    }


    public static function getJobRegionText($val, $default = '')
    {
        $options = OptionUtil::getHouseOption();
        if($val && $options->has($val)){
            return $options->get($val);
        }
        return $default;
    }

    public static function getHouseRegionText($val, $default = '')
    {
        $options = OptionUtil::getHouseOption();
        if($val && $options->has($val)){
            return $options->get($val);
        }
        return $default;
    }

    public static function getJobTimeOptionText($val, $default = '')
    {
        $options = OptionUtil::getJobTimeOption();
        if($val && $options->has($val)){
            return $options->get($val);
        }
        return $default;
    }



    /**
     * 各种下拉筛选的文字
     * @param $key
     * @return string $text
     */
    public static function getAllSelectText($key,$value)
    {
        $text = true;
        switch ($key)
        {
            case 'labels':
                $text = FormatUtil::getLabel($value);
                break;
            case 'status':
                $text = FormatUtil::getCustomerStatus($value);
                break;
            case 'wechat_status':
                $text = FormatUtil::getWxStatus($value);
                break;
            case 'region':
                $text = FormatUtil::getIntentionRegion($value);
                break;
            case 'area':
                $text = FormatUtil::getIntentionArea($value);
                break;
            case 'type':
                $text = FormatUtil::getIntentionType($value);
                break;
            case 'total':
                $text = FormatUtil::getIntentionTotal($value);
                break;
            case 'price':
                $text = FormatUtil::getIntentionPrice($value);
                break;
            case 'income':
                $text = FormatUtil::getIncomeText($value);
                break;
            case 'manager':
                $text = FormatUtil::getCustomerManager($value);
                break;
            case 'buy_type':
                $text = FormatUtil::getCustomerBuyType($value);
                break;
            case 'industry':
                $text = FormatUtil::getIndustryText($value);
                break;
            case 'job':
                $text = FormatUtil::getJobText($value);
                break;
            case 'job_time':
                $text = FormatUtil::getJobTimeOptionText($value);
                break;
            case 'buy_house':
                $text = FormatUtil::getBuyHouseText($value);
                break;
            case 'financial':
                $text = FormatUtil::getFinancialText($value);
                break;
            case 'introduce':
                $text = FormatUtil::getIntroduceText($value);
                break;
            case 'channel':
                $text = FormatUtil::getChannelText($value);
                break;
            case 'age':
                $text = FormatUtil::getAgeText($value);
                break;
            case 'house_old':
                $text = FormatUtil::getHouseOldText($value);
                break;
            case 'job_region':
                $text = FormatUtil::getJobRegionText($value);
                break;
            case 'house_region':
                $text = FormatUtil::getHouseRegionText($value);
                break;
            default:
                $text = false;
                break;
        }
        return $text;
    }


    public static function getStatusColor($val,$default = '')
    {
        $isMapping = [
            Customer::STATUS_WAIT_MEET     =>  'background-color: #ff851b',
            Customer::STATUS_WAIT_ALLOT    =>  'background-color: #dd4b39',
            Customer::STATUS_MEET          =>  'background-color: #0073b7',
            Customer::STATUS_SUCCESS       =>  'background-color: #00a65a',
            Customer::STATUS_END           =>  'background-color: #d2d6de',
            Customer::STATUS_COME          =>  'background-color: #605ca8',
            Customer::STATUS_REAL          =>  '',
        ];
        if (array_key_exists($val,$isMapping)) {
            return $isMapping[$val];
        }
        return $default;
    }

    public static function getLabelsColor($val,$default = '')
    {
        $isMapping = [
            Customer::LABEL_S => 'background-color: #f012be',
            Customer::LABEL_A => 'background-color: #dd4b39',
            Customer::LABEL_B => 'background-color: #605ca8',
            Customer::LABEL_C => 'background-color: #ff851b',
            Customer::LABEL_D => 'background-color: #00a65a',
            Customer::LABEL_E => 'background-color: #0073b7',
        ];
        if (array_key_exists($val,$isMapping)) {
            return $isMapping[$val];
        }
        return $default;
    }

    public static function getRemindTypeColor($val,$default = '')
    {
        $isMapping = [
            Base::REMIND_TYPE_OUT => 'background-color: #f44',
            Base::REMIND_TYPE_LOG => 'background-color: #38f',
        ];
        if (array_key_exists($val,$isMapping)) {
            return $isMapping[$val];
        }
        return $default;
    }

    public static function getLogTypeColor($val,$default = '')
    {
        $isMapping = [
            Base::LOG_TYPE_MEET     => 'background-color: #0073b7',
            Base::LOG_TYPE_COME     => 'background-color: #9F35FF',
            Base::LOG_TYPE_SUCCESS  => 'background-color: #00a65a',
        ];
        if (array_key_exists($val,$isMapping)) {
            return $isMapping[$val];
        }
        return $default;
    }




}