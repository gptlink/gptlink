<?php

namespace App\Exception;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
class ErrCode extends AbstractConstants
{
    /**
     * @Message("未知错误")
     */
    public const UNKNOWN = 99999;

    /**
     * @Message("请求出错，请稍后再试")
     */
    public const BAD_REQUEST = 400;

    /**
     * @Message("未授权的登陆，请先登录")
     */
    public const AUTHENTICATION = 401;

    /**
     * @Message("权限不足，无法访问")
     */
    public const FORBIDDEN = 403;

    /**
     * @Message("访问的地址不存在")
     */
    public const NOT_FOUND = 404;

    /**
     * @Message("请求方式错误")
     */
    public const METHOD_NOT_ALLOW = 405;

    /**
     * @Message("提交的数据有误，请修改后重试")
     */
    public const VALIDATE_ERR = 422;

    /**
     * @Message("服务器错误")
     */
    public const SERVER_ERROR = 500;

    /**
     * @Message("数据库/redis链接失败")
     */
    public const SERVER_CONNECTION_FAIL = 2002;

    /**
     * @Message("请求的资源不存在")
     */
    public const MODEL_NOT_FOUND = 4004;

    /**
     * @Message("可用额度不足")
     */
    public const MEMBER_INSUFFICIENT_BALANCE = 1000;

    /**
     * @Message("服务器错误，验证码未发送成功")
     */
    public const SMS_SEND_FAIL = 1001;

    /**
     * @Message("系统对话资源不足，请稍后再试")
     */
    public const SYSTEM_INSUFFICIENT_BALANCE = 1002;

    /**
     * @Message("未配置正确的apikey")
     */
    public const SYSTEM_KEY_INVALID = 1003;

    /**
     * @Message("此功能未开放")
     */
    public const SYSTEM_FEATURE_DISABLED = 1004;

    /**
     * @Message("用户信息获取失败，清刷新页面后重试")
     */
    public const WECHAT_OPENID_GET_FAIL = 10001;

    /**
     * @Message("此手机号已绑定其他微信，请更换手机号再进行绑定")
     */
    public const USER_MOBILE_IS_BIND = 10002;

    /**
     * @Message("兑换码无效或已被使用")
     */
    public const CDK_INVALID = 10003;

    /**
     * @Message("兑换码无效或已被使用")
     */
    public const CDK_IS_EXPIRED = 10004;

    /**
     * @Message("兑换套餐失效，请联系客服更换")
     */
    public const CDK_PACKAGE_NOT_FOUND = 10005;

    /**
     * @Message("系统未初始化完成，请先前往配置")
     */
    public const APIKEY_NOT_FOUND = 10006;

    /**
     * @Message("用户名或密码错误")
     */
    public const USER_LOGIN_FAIL = 10007;

    /**
     * @Message("用户未注册，请先进行注册")
     */
    public const USER_NOT_FOUND = 10008;

    /**
     * @Message("未开启此渠道注册")
     */
    public const REGISTER_TYPE_NOT_SUPPORT = 10009;

    /**
     * @Message("验证失败，请重新校验")
     */
    public const USER_VERIFY_FAIL = 10010;

    /**
     * @Message("用户已注册，请更换后再试")
     */
    public const USER_MOBILE_IS_REGISTER = 10011;

    /**
     * @Message("存在违禁词，请修改后再重尝试")
     */
    public const CHAT_CONTAINS_PROHIBITED_WORDS = 10012;

    /**
     * @Message("套餐已存在使用记录，不可删除")
     */
    public const PACKAGE_IS_BIND_USER = 10013;

    /**
     * @Message("套餐已存在使用记录，不可删除")
     */
    public const PACKAGE_IS_BIND_TASK = 10014;

    /**
     * @Message("该套餐以下线，请刷新页面后重试")
     */
    public const PACKAGE_IS_OFFLINE = 10107;

    /**
     * @Message("您已是分销员，无需重复申请")
     */
    public const MEMBER_IS_SALESMAN = 10108;

    /**
     * @Message("余额不足")
     */
    public const SALESMAN_INSUFFICIENT_BALANCE = 10109;

    /**
     * @Message("你的账号已被禁用")
     */
    public const MEMBER_ACCOUNT_DISABLED = 10203;

    /**
     * @Message("请先配置任务")
     */
    public const TASK_ONT_FOUND_UPDATE_STATUS = 20002;

    /**
     * @Message("验证码在时效中, 无需重新获取")
     */
    public const LOGIN_SMS_CODE_VALID = 20003;

    /**
     * @Message("验证码错误或已失效")
     */
    public const LOGIN_SMS_CODE_ERROR = 20004;

    /**
     * @Message("类型无效")
     */
    public const TYPE_IS_INVALID = 20005;

    /**
     * @Message("账号或密码错误")
     */
    public const ADMIN_LOGIN_FAIL = 30001;

    /**
     * @Message("错误次数过多，请10分钟后再试")
     */
    public const ADMIN_LOGIN_ATTEMPTS = 30002;

    /**
     * @Message("获取七牛云文件信息失败")
     */
    public const MATERIAL_CATEGORY_FILE_INFO = 40200;
}
