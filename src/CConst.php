<?php
namespace dekuan\deoss;

class CConst {

	const CONST_KEY_STS_SERVER 				= 'stsserver';						//	ali sts验证服务器代码,当前只支持杭州
	const CONST_KEY_ACCESS_KEY_ID 			= 'accesskeyid';					//	ali oss accessKeyId
	const CONST_KEY_ACCESS_KEY_SECRET 		= 'accesskeysecret';				//	ali oss accessKeySecret
	const CONST_KEY_ROLEARN 				= 'rolearn';						//	ali sts roleArn角色资源描述符
	const CONST_KEY_TOKEN_EFFECTIVE_TIME 	= 'tokeneffectivetime';				//	ali sts token有效时长
	const CONST_KEY_POLICY					= 'policy';							//	ali sts token policy配置

	const CONST_DEFAULT_IF_USE_INNER = self::CONST_USE_INNER;	//	是否使用内网;
	const CONST_NOT_USE_INNER = 0;								//	使用外网标识;与deoss包中const值保持一致,请勿修改
	CONST CONST_USE_INNER = 1;									//	使用内网标识;与deoss包中const值保持一致,请勿修改

	CONST CONST_TIMEOUT = 5;									//	请求超时时间
	CONST CONST_CONN_TIMEOUT = 10;								//	请求连接超时时间

	CONST CONST_IMG_PROCESS_URL_VALID_TIME = 3600;				//	图片访问url有效时间

}

