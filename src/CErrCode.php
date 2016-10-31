<?php
namespace dekuan\deoss;

class CErrCode {
	const ERR_SUCCESS 	= 0;					//	成功
	const ERR_BASE		= -10000;				//	基础
	const ERR_UNKNOWN 	= self::ERR_BASE;		//	未知错误

	const ERR_STS_GET_TOKEN_ARR_CONFIG 					= self::ERR_BASE - 1;		//	STS 获得token接口,配置参数错误
	const ERR_STS_GET_TOKEN_CONFIG_STS_SERVER 			= self::ERR_BASE - 2;		//	STS 获得token接口,sts server配置参数错误
	const ERR_STS_GET_TOKEN_CONFIG_ACCESS_KEY_ID 		= self::ERR_BASE - 3;		//	STS 获得token接口,oss accessKeyId配置参数错误
	const ERR_STS_GET_TOKEN_CONFIG_ACCESS_KEY_SECRET 	= self::ERR_BASE - 4;		//	STS 获得token接口,oss accessKeySecret配置参数错误
	const ERR_STS_GET_TOKEN_CONFIG_ROLEARN 				= self::ERR_BASE - 5;		//	STS 获得token接口,sts 资源描述符配置参数错误
	const ERR_STS_GET_TOKEN_CONFIG_TOKEN_EFFECTIVE_TIME	= self::ERR_BASE - 6;		//	STS 获得token接口,sts token有效时长参数错误
	const ERR_STS_GET_TOKEN_CLIENT_NAME					= self::ERR_BASE - 7;		//	STS 获得token接口,用户端oss名称参数错误
	const ERR_STS_GET_TOKEN_RESPONSE					= self::ERR_BASE - 8;		//	STS 获得token接口,返回参数错误
	const ERR_STS_GET_POLICY							= self::ERR_BASE - 9;		//	STS 获得token接口,policy参数错误
}
