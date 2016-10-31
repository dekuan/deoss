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

	const ERR_OSS_UPLOAD_PARA_BUCKET_NAME				= self::ERR_BASE - 20;		//	oss 上传文件到oss,bucket name参数错误
	const ERR_OSS_UPLOAD_PARA_FILE_NAME					= self::ERR_BASE - 21;		//	oss 上传文件到oss,file name参数错误
	const ERR_OSS_UPLOAD_PARA_FILE_PATH					= self::ERR_BASE - 22;		//	oss 上传文件到oss,file path参数错误
	const ERR_OSS_UPLOAD_CLIENT_ERR						= self::ERR_BASE - 23;		//	oss 上传文件到oss,获得client实例失败
	const ERR_OSS_UPLOAD_FAIL							= self::ERR_BASE - 24;		//	oss 上传文件到oss,上传失败

	const ERR_OSS_GET_CLIENT_PARA_ACCESS_KEY_ID			= self::ERR_BASE - 30;		//	oss 获得client实例,accessKeyId参数错误
	const ERR_OSS_GET_CLIENT_PARA_ACCESS_KEY_SECRET		= self::ERR_BASE - 31;		//	oss 获得client实例,accessKeySecret参数错误
	const ERR_OSS_GET_CLIENT_PARA_USE_INNER				= self::ERR_BASE - 32;		//	oss 获得client实例,是否使用内网标识参数错误
	const ERR_OSS_GET_CLIENT_PARA_TIMEOUT				= self::ERR_BASE - 33;		//	oss 获得client实例,请求超时时间参数错误
	const ERR_OSS_GET_CLIENT_PARA_CONN_TIMEOUT			= self::ERR_BASE - 34;		//	oss 获得client实例,请求连接超时时间参数错误
	const ERR_OSS_GET_CLIENT_PARA_BUCKET_INNER_URL		= self::ERR_BASE - 35;		//	oss 获得client实例,内网连接网络参数错误
	const ERR_OSS_GET_CLIENT_PARA_BUCKET_URL			= self::ERR_BASE - 36;		//	oss 获得client实例,外网连接网络参数错误
	const ERR_OSS_GET_CLIENT_PARA_ARR					= self::ERR_BASE - 37;		//	oss 获得client实例,请求参数错误

	const ERR_OSS_DOES_EXISTS_OBJECT_PARA_ARR			= self::ERR_BASE - 40;		//	oss 判断对象是否存在,参数数组错误
	const ERR_OSS_DOES_EXISTS_OBJECT_PARA_BUCKET		= self::ERR_BASE - 41;		//	oss 判断对象是否存在,bucket name参数错误
	const ERR_OSS_DOES_EXISTS_OBJECT_PARA_FILENAME		= self::ERR_BASE - 42;		//	oss 判断对象是否存在,对象名参数错误
	const ERR_OSS_DOES_EXISTS_OBJECT_CLIENT				= self::ERR_BASE - 43;		//	oss 判断对象是否存在,获得client对象失败

	const ERR_OSS_GET_OSS_PARA_ARR						= self::ERR_BASE - 50;		//	oss 获得oss对象,参数列表错误
	const ERR_OSS_GET_OSS_PARA_BUCKET					= self::ERR_BASE - 51;		//	oss 获得oss对象,bucket name参数错误
	const ERR_OSS_GET_OSS_PARA_FILE_NAME				= self::ERR_BASE - 52;		//	oss 获得oss对象,对象名参数错误
	const ERR_OSS_GET_OSS_FAIL							= self::ERR_BASE - 53;		//	oss 获得oss对象,结果错误
	const ERR_OSS_GET_OSS_CLIENT						= self::ERR_BASE - 54;		//	oss 获得oss对象,client获取失败

	const ERR_OSS_GET_CLIENT_WITH_IMG_PARA_ARR					= self::ERR_BASE - 60;		//	oss 获得oss对象,client获取失败
	const ERR_OSS_GET_CLIENT_WITH_IMG_PARA_ACCESS_KEY_ID		= self::ERR_BASE - 61;		//	oss 获得oss对象,assessKeyId参数错误
	const ERR_OSS_GET_CLIENT_WITH_IMG_PARA_ACCESS_KEY_SECRET	= self::ERR_BASE - 62;		//	oss 获得oss对象,assessKeySecret参数错误
	const ERR_OSS_GET_CLIENT_WITH_IMG_PARA_TIMEOUT				= self::ERR_BASE - 63;		//	oss 获得oss对象,超时时间参数错误
	const ERR_OSS_GET_CLIENT_WITH_IMG_PARA_CONN_TIMEOUT			= self::ERR_BASE - 64;		//	oss 获得oss对象,连接超时时间参数错误
	const ERR_OSS_GET_CLIENT_WITH_IMG_PARA_IMG_URL				= self::ERR_BASE - 65;		//	oss 获得oss对象,图片访问url参数错误

	const ERR_OSS_GET_IMG_PROCESS_PARA_ARR						= self::ERR_BASE - 70;		//	oss 获得图片访问地址,参数数组错误
	const ERR_OSS_GET_IMG_PROCESS_PARA_BUCKET					= self::ERR_BASE - 71;		//	oss 获得图片访问地址,bucket参数错误
	const ERR_OSS_GET_IMG_PROCESS_PARA_FILENAME					= self::ERR_BASE - 72;		//	oss 获得图片访问地址,filename参数错误
	const ERR_OSS_GET_IMG_PROCESS_PARA_VALID_TIME				= self::ERR_BASE - 73;		//	oss 获得图片访问地址,有效期参数错误
	const ERR_OSS_GET_IMG_PROCESS_SIGN_RTN						= self::ERR_BASE - 74;		//	oss 获得图片访问地址,获得的返回值错误
	const ERR_OSS_GET_IMG_PROCESS_GET_CLIENT					= self::ERR_BASE - 75;		//	oss 获得图片访问地址,获得client失败


}
