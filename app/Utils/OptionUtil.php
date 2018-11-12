<?php
namespace App\Utils;
use App\Models\Base;
use App\Models\Customer;
use App\Models\CustomerSuccess;
use App\Models\Employee;
use App\Models\EmployeeBonus;
use App\Models\ExpressCompany;
use App\Models\GoodCategory;
use App\Models\Project;
use App\Models\Subject;
use App\Models\Tag;
use App\Models\Team;
use App\Services\EmployeeService;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Cache;

/**
 * 构建 Option 的
 */
class OptionUtil
{
    /**
     * 是否
     * @return \Illuminate\Support\Collection
     */
    public static function getIsOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(Base::IS_TRUE,'是');
        $options->put(Base::IS_FALSE,'否');
        $options->all();
        return $options;
    }

    /**
     * 奖金审核类型
     * @return \Illuminate\Support\Collection
     */
    public static function getBonusTypeOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(EmployeeBonus::TYPE_EMPLOYEE,'员工提成奖金');
        $options->put(EmployeeBonus::TYPE_MANAGER,'管理组提成奖金');
        $options->put(EmployeeBonus::TYPE_COME,'案场组提成奖金');
        $options->all();
        return $options;
    }



    /**
     * 是否导入
     * @return \Illuminate\Support\Collection
     */
    public static function getImportStatusOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(Base::IMPORT_FALSE,'未导入');
        $options->put(Base::IMPORT_TRUE,'已导入');
        $options->all();
        return $options;
    }

    /**
     * 在职情况
     * @return \Illuminate\Support\Collection
     */
    public static function getDeleteOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(Base::DELETE_FALSE,'在职');
        $options->put(Base::DELETE_TRUE,'离职');
        $options->all();
        return $options;
    }

    /**
     * 性别
     * @return \Illuminate\Support\Collection
     */
    public static function getGenderOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(1,'男');
        $options->put(-1,'女');
        $options->all();
        return $options;
    }

    /**
     * 意向等级
     * @return \Illuminate\Support\Collection
     */
    public static function getLabelOption($filter = false)
    {
        $options = null;
        $options = collect($options);
        if(!$filter){
            $options->put(Base::LABEL_S,'== S ==');
            $options->put(Base::LABEL_A,'== A ==');
            $options->put(Base::LABEL_B,'== B ==');
            $options->put(Base::LABEL_C,'== C ==');
            $options->put(Base::LABEL_D,'== D ==');
//            $options->put(Base::LABEL_E,'== E ==');
        }else{
            $options->put(Base::LABEL_S,'S');
            $options->put(Base::LABEL_A,'A');
            $options->put(Base::LABEL_B,'B');
            $options->put(Base::LABEL_C,'C');
            $options->put(Base::LABEL_D,'D');
//            $options->put(Base::LABEL_E,'E');
        }
        $options->all();
        return $options;
    }

    /**
     * 员工列表
     * @param Employee $employee
     * @param bool $filter
     * @return \Illuminate\Support\Collection
     */
    public static function getEmployeeOption($employee,$filter = false)
    {
        $name = $filter?'true':'false';
        $cacheName = __FUNCTION__.$employee->id.$name;
        if(Cache::has($cacheName)){
            return Cache::get($cacheName);
        }else{
            $options = null;
            $ids = EmployeeService::getEmployeeAuth($employee);
            $query = Employee::where('is_delete','=',Base::DELETE_FALSE);
            if($ids){
                $query->whereIn('id',$ids);
            }
            if($filter){
                //会和客户绑定的角色
                $query->join('admin_role_users', function ($join) {
                    $join->on('employees.id', '=', 'admin_role_users.user_id')
                        ->whereIn('admin_role_users.role_id', [2,3,4,5,9]);
                });
            }
            $options = $query->get()->pluck('name', 'id');
            $options = collect($options);
            if(!$filter){
                $options->prepend('==请先选择员工==',0);
            }
            $options->all();
            Cache::put($cacheName,$options,10);
            return $options;
        }
    }


    /**
     * 员工列表(按角色)
     * @param $slugArray
     * @return \Illuminate\Support\Collection|null
     */
    public static function getEmployeeByRoleOption($slugArray = null)
    {
        $options = null;
        $employeeQuery = Employee::query()
            ->where('is_delete','=',Base::DELETE_FALSE);
        if($slugArray){
            $employeeQuery->whereHas('roles', function ($query) use ($slugArray){
                $query->whereIn('slug', $slugArray);
            });
        }
        $options = $employeeQuery->get()->pluck('name', 'id');
        $options = collect($options);
        $options->prepend('==请先选择员工==',0);
        $options->all();
        return $options;
    }

    /**
     * 客户成交状态
     * @return \Illuminate\Support\Collection
     */
    public static function getCustomerSuccessStatusOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(CustomerSuccess::STATUS_BUY,'认购');
        $options->put(CustomerSuccess::STATUS_SIGN,'签约');
        $options->put(CustomerSuccess::STATUS_LOSE,'缺件');
        $options->put(CustomerSuccess::STATUS_WAIT,'待放款');
        $options->put(CustomerSuccess::STATUS_END,'完结');
        $options->all();
        return $options;
    }



    /**
     * 客户状态
     * @param Employee $employee
     * @param boolean $isEdit
     * @return \Illuminate\Support\Collection
     */
    public static function getCustomerStatusOption($employee = null,$isEdit = false)
    {
        $options = null;
        $options = collect($options);
        $ids = EmployeeService::getCustomerStatusAuth($employee,$isEdit);
        foreach ($ids as $id){
            $options->put($id,FormatUtil::getCustomerStatus($id));
        }
        $options->all();
        return $options;
    }

    /**
     * 客户跟进筛选
     * @param bool $filter
     * @return \Illuminate\Support\Collection
     */
    public static function getCustomerStatusTopOption($filter = false)
    {
        $options = null;
        $options = collect($options);
        $options->put(Base::CUSTOMER_STATUS_WAIT_MEET,'待约访');
        $options->put(Base::CUSTOMER_STATUS_MEET,'约访中');
        $options->put(Base::CUSTOMER_STATUS_END,'无效');
        $options->all();
        return $options;
    }

    /**
     * 标签类型
     * @return \Illuminate\Support\Collection
     */
    public static function getTagTypeOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(Base::TAG_TYPE_PROJECT,'项目标签');
        $options->put(Base::TAG_TYPE_SUBJECT,'产品标签');
        $options->put(Base::TAG_TYPE_EMPLOYEE,'员工标签');
        $options->put(Base::TAG_TYPE_CUSTOMER,'客户标签');
        $options->all();
        return $options;
    }

    /**
     * 标签类型
     * @return \Illuminate\Support\Collection
     */
    public static function getTagsOption($type)
    {
        $cacheName = __FUNCTION__;
        if(Cache::has($cacheName)){
            return Cache::get($cacheName);
        }else{
            $options = Tag::where('type',$type)->orderBy('sort','desc')->pluck('name','id');
            Cache::put($cacheName,$options,10);
            return $options;
        }
    }

    /**
     * 产品列表
     * @return \Illuminate\Support\Collection
     */
    public static function getSubjectsOption()
    {
        $cacheName = __FUNCTION__;
        if(Cache::has($cacheName)){
            return Cache::get($cacheName);
        }else{
            $options = Subject::where('is_delete',Base::DELETE_FALSE)->orderBy('sort','desc')->pluck('name','id');
            Cache::put($cacheName,$options,10);
            return $options;
        }
    }

    /**
     * 项目列表
     * @return \Illuminate\Support\Collection
     */
    public static function getProjectsOption()
    {
        $cacheName = __FUNCTION__;
        if(Cache::has($cacheName)){
            return Cache::get($cacheName);
        }else{
            $options = Project::where('is_delete',Base::DELETE_FALSE)->orderBy('sort','desc')->pluck('name','id');
            Cache::put($cacheName,$options,10);
            return $options;
        }
    }

    /**
     * 经纪人列表
     * @return \Illuminate\Support\Collection
     */
    public static function getBrokersOption()
    {
        $options = Employee::join('admin_role_users', function ($join) {
            $join->on('employees.id', '=', 'admin_role_users.user_id')
                ->where('admin_role_users.role_id', 6);
        })->where('is_delete',Base::DELETE_FALSE)->pluck('name','id');
        return $options;
    }

    /**
     * 员工列表按角色
     * @return \Illuminate\Support\Collection
     */
    public static function getEmployeeRoleOption($roles)
    {
        $options = Employee::whereHas('roles',function($q) use ($roles){
            $q->whereIn('slug',$roles);
        })->where('is_delete',Base::DELETE_FALSE)->pluck('name','id');
        return $options;
    }

    /**
     * 团队列表
     * @return \Illuminate\Support\Collection
     */
    public static function getTeamOption()
    {
        $cacheName = __FUNCTION__;
        if(Cache::has($cacheName)){
            return Cache::get($cacheName);
        }else{
            $options = Team::all()->pluck('name','id');
            Cache::put($cacheName,$options,10);
            return $options;
        }
    }

    /**
     * 排序参数列表
     * @return \Illuminate\Support\Collection
     */
    public static function getOrderKeyOption()
    {
        $options = null;
        $options = collect($options);
        $options->put('log_time','约访时间');
        $options->put('save_time','跟进时间');
        $options->put('created_at','报备时间');
        $options->put('come_time','预计来访');
        $options->put('latest_come_time','来访时间');
        $options->put('success_time','成交时间');
        $options->put('wechat_add_time','微信时间');
        $options->all();
        return $options;
    }

    /**
     * 意向类别
     * @return \Illuminate\Support\Collection
     */
    public static function getTendStatusOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(Base::TEND_STATUS_WAIT,'待确认');
        $options->put(Base::TEND_STATUS_TRUE,'有意向');
        $options->put(Base::TEND_STATUS_FALSE,'无意向');
        $options->all();
        return $options;
    }

    /**
     * 意向类别
     * @return \Illuminate\Support\Collection
     */
    public static function getIntentionTypeOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(0,'不限');
        $options->put(1,'住宅');
        $options->put(2,'商铺');
        $options->put(3,'门面');
        $options->put(4,'公寓');
        $options->put(5,'洋房');
        $options->put(6,'别墅');
        $options->put(7,'写字楼');
        $options->all();
        return $options;
    }


    /**
     * 老家
     * @return \Illuminate\Support\Collection
     */
    public static function getHouseOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(0,'不限');
        $options->put(1,'庐阳区');
        $options->put(2,'蜀山区');
        $options->put(3,'包河区');
        $options->put(4,'瑶海区');
        $options->put(5,'经开区');
        $options->put(6,'高新区');
        $options->put(7,'新站区');
        $options->put(8,'滨湖新区');
        $options->put(9,'北城新区');
        $options->put(10,'政务区');
        $options->put(11,'三县');
        $options->put(12,'皖北');
        $options->put(13,'皖南');
        $options->put(14,'省外');
        $options->put(15,'北上广深');
        $options->all();
        return $options;
    }

    /**
     * 意向区域
     * @return \Illuminate\Support\Collection
     */
    public static function getIntentionRegionOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(0,'不限');
        $options->put(1,'庐阳区');
        $options->put(2,'蜀山区');
        $options->put(3,'包河区');
        $options->put(4,'瑶海区');
        $options->put(5,'经开区');
        $options->put(6,'高新区');
        $options->put(7,'新站区');
        $options->put(8,'滨湖新区');
        $options->put(9,'北城新区');
        $options->put(10,'政务区');
        $options->put(11,'肥东县');
        $options->put(12,'肥西县');
        $options->put(13,'长丰县');
        $options->put(14,'庐江');
        $options->put(15,'巢湖');
        $options->all();
        return $options;
    }

    /**
     * 意向面积
     * @return \Illuminate\Support\Collection
     */
    public static function getIntentionAreaOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(0,'不限');
        $options->put(1,'60平以下');
        $options->put(2,'60-80平');
        $options->put(3,'80-100平');
        $options->put(4,'100-120平');
        $options->put(5,'120-140平');
        $options->put(6,'140-200平');
        $options->put(7,'200平以上');
        $options->all();
        return $options;
    }

    /**
     * 意向单价
     * @return \Illuminate\Support\Collection
     */
    public static function getIntentionPriceOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(0,'不限');
        $options->put(1,'6000元以下');
        $options->put(2,'6000-8000元');
        $options->put(3,'8000-9000元');
        $options->put(4,'9000-10000元');
        $options->put(5,'10000-12000元');
        $options->put(6,'12000-15000元');
        $options->put(7,'15000-20000元');
        $options->put(8,'20000元以上');
        $options->all();
        return $options;
    }

    /**
     * 意向总价
     * @return \Illuminate\Support\Collection
     */
    public static function getIntentionTotalOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(0,'不限');
        $options->put(1,'50万以下');
        $options->put(2,'50-70万');
        $options->put(3,'70-90万');
        $options->put(4,'90-110万');
        $options->put(5,'110-150万');
        $options->put(6,'150-200万');
        $options->put(7,'200万以上');
        $options->all();
        return $options;
    }

    /**
     * 客户来源
     * @return \Illuminate\Support\Collection
     */
    public static function getChannelOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(0,'不限');
        $options->put(1,'公司话单');
        $options->put(2,'客户介绍');
        $options->put(3,'派单拓客');
        $options->put(4,'58同城');
        $options->put(5,'安居客');
        $options->put(6,'其他网络');
        $options->put(7,'自行拓客');
        $options->put(8,'同批客户');
        $options->put(9,'摇一摇');
        $options->put(10,'案场来访新增');
        $options->put(11,'案场来电新增');
        $options->all();
        return $options;
    }

    /**
     * 成交客户来源
     * @return \Illuminate\Support\Collection
     */
    public static function getSuccessChannelOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(1,'致行');
        $options->put(2,'自来');
        $options->put(3,'分销');
        $options->all();
        return $options;
    }

    /**
     * 付款方式
     * @return \Illuminate\Support\Collection
     */
    public static function getPayTypeOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(1,'按揭');
        $options->put(2,'全款');
        $options->all();
        return $options;
    }

    /**
     * 购买用途筛选
     * @return \Illuminate\Support\Collection
     */
    public static function getBuyTypeOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(0,'不限');
        $options->put(1,'自用');
        $options->put(2,'投资');
        $options->put(3,'两者都有');
        $options->all();
        return $options;
    }

    /**
     * 所处行业筛选
     * @return \Illuminate\Support\Collection
     */
    public static function getIndustryOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(0,'不限');
        $options->put(1,'政府和事业单位');
        $options->put(2,'农林牧渔');
        $options->put(3,'采矿');
        $options->put(4,'医药卫生');
        $options->put(5,'制造业');
        $options->put(6,'建筑房地产');
        $options->put(7,'批发零售');
        $options->put(8,'住宿餐饮');
        $options->put(9,'金融证券');
        $options->put(10,'文化教育');
        $options->put(11,'信息科技');
        $options->put(12,'互联网和媒体');
        $options->put(13,'娱乐');
        $options->all();
        return $options;
    }

    /**
     * 工作类型筛选
     * @return \Illuminate\Support\Collection
     */
    public static function getJobOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(0,'不限');
        $options->put(1,'私企');
        $options->put(2,'国企事业');
        $options->put(3,'开店');
        $options->put(4,'开厂');
        $options->put(5,'开公司');
        $options->all();
        return $options;
    }

    /**
     * 所处行业时间筛选
     * @return \Illuminate\Support\Collection
     */
    public static function getJobTimeOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(0,'不限');
        $options->put(1,'2年以下');
        $options->put(2,'2-5年');
        $options->put(3,'5-10年');
        $options->put(4,'10年以上');
        $options->all();
        return $options;
    }

    /**
     * 年收入筛选
     * @return \Illuminate\Support\Collection
     */
    public static function getIncomeOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(0,'不限');
        $options->put(1,'50万以下');
        $options->put(2,'50-100万');
        $options->put(3,'100-150万');
        $options->put(4,'150-200万');
        $options->put(5,'200-300万');
        $options->put(6,'300-500万');
        $options->put(7,'500万以上');
        $options->all();
        return $options;
    }

    /**
     * 决策权筛选
     * @return \Illuminate\Support\Collection
     */
    public static function getCustomerManagerOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(0,'不限');
        $options->put(1,'自己');
        $options->put(2,'爱人');
        $options->put(3,'共同决策');
        $options->put(4,'其他人');
        $options->all();
        return $options;
    }


    /**
     * 合肥买住宅经验筛选
     * @return \Illuminate\Support\Collection
     */
    public static function getBuyHouseOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(0,'不限');
        $options->put(1,'无房');
        $options->put(2,'1套房');
        $options->put(3,'2套房');
        $options->put(4,'3套房');
        $options->put(5,'3套房以上');
        $options->all();
        return $options;
    }

    /**
     * 理财方式筛选
     * @return \Illuminate\Support\Collection
     */
    public static function getFinancialOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(0,'不限');
        $options->put(1,'活定期存银行');
        $options->put(2,'买理财产品');
        $options->put(3,'炒股');
        $options->put(4,'买房');
        $options->put(5,'借高利贷');
        $options->put(6,'投资项目');
        $options->put(7,'扩大生意');
        $options->all();
        return $options;
    }

    /**
     * 介绍客户筛选
     * @return \Illuminate\Support\Collection
     */
    public static function getIntroduceOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(0,'不限');
        $options->put(1,'无介绍');
        $options->put(2,'已介绍1位');
        $options->put(3,'已介绍2位');
        $options->put(4,'已介绍多位');
        $options->put(5,'已介绍成交1位');
        $options->put(6,'已介绍成交2位');
        $options->put(7,'已介绍成交多位');
        $options->all();
        return $options;
    }

    /**
     * 介绍客户筛选
     * @return \Illuminate\Support\Collection
     */
    public static function getAgeOption()
    {
        $options = null;
        $options = collect($options);
        $options->put(0,'不限');
        $options->put(1,'30以下');
        $options->put(2,'30-40');
        $options->put(3,'40-50');
        $options->put(4,'50以上');
        $options->all();
        return $options;
    }


}