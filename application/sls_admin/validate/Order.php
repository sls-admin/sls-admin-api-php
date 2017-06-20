<?php
/**
 * Created by PhpStorm.
 * User: mamanman
 * Date: 2017/2/7
 * Time: 下午12:25
 */

namespace app\sls_admin\validate;

use think\Validate;

class Order extends Validate {
	protected $rule = [
		[
			'name',
			'require|unique:order|length:1,226',
			'订单名称不能为空|订单名称已存在|订单名称长度必须在1-226位之间',
		],
		[
			'status',
			'require',
			'订单状态不能为空',
		],
	];
}