<?php
namespace dekuan\deoss;

//use OSS\AssumeRoleRequest;
//use \Sts\Request\V20150401 as Sts;
use OSS\Core\OssException;
use OSS\OssClient;


class COSSOperate
{
	/**
	 * 上传对象到oss
	 * $arrPara参数列表:
	 * <li> 'AccessKeyId' 		: [必需]请求accessKeyId参数
	 * <li> 'AccessKeySecret'	: [必需]请求accessKeySecret参数
	 * <li> 'useinner'          : [非必需]请求是否使用内网标识,默认CConst::CONST_DEFAULT_IF_USE_INNER;
	 * 							取值范围:CConst::CONST_NOT_USE_INNER,CConst::CONST_USE_INNER
	 * <li> 'timeout'			: [非必需]client请求超时时间,默认CConst::CONST_TIMEOUT
	 * <li> 'conntimeout'		: [非必需]client连接超时时间,默认CConst::CONST_CONN_TIMEOUT
	 * <li> 'bktinnerurl'		: [必需]请求bucket内网连接地址
	 * <li> 'bkturl'			: [必需]请求bucket外网连接地址
	 * <li> 'bucket'			: [必需]上传到的bucket名称
	 * <li> 'filename'			: [必需]上传的对象名称,如果存在相同名称的对象,则覆盖
	 * <li> 'filepath'			: [必需]上传的对象本地地址
	 * <li> 'SecurityToken'		: [非必需]使用token的accessKeyId及secret需要带此参数,参数为请求token中的原值
	 *
	 * @author wanganning
	 * @modify-log
	 *        name            date            reason
	 *        王安宁			2016-10-31			创建
	 *
	 * @param      $arrPara		array	参数列表
	 *
	 * @return int		错误码
	 * @throws \OSS\Core\OssException
	 */
	public static function uploadToOSS( $arrPara )
	{
		$sBucketName = array_key_exists( 'bucket', $arrPara ) ? $arrPara[ 'bucket' ] : null;
		if ( ! is_string( $sBucketName ) || strlen( $sBucketName ) <= 0 )
		{
			return CErrCode::ERR_OSS_UPLOAD_PARA_BUCKET_NAME;
		}

		$sFileName = array_key_exists( 'filename', $arrPara ) ? $arrPara[ 'filename' ] : null;
		if ( ! is_string( $sFileName ) || strlen( $sFileName ) <= 0 )
		{
			return CErrCode::ERR_OSS_UPLOAD_PARA_FILE_NAME;
		}

		$sFilePath = array_key_exists( 'filepath', $arrPara ) ? $arrPara[ 'filepath' ] : null;
		if ( ! is_string( $sFilePath ) || strlen( $sFilePath ) <= 0 )
		{
			return CErrCode::ERR_OSS_UPLOAD_PARA_FILE_PATH;
		}

		$nErrCode = CErrCode::ERR_UNKNOWN;

		$oClient = null;
		$nErrCode = self::getClient( $arrPara, $oClient );

		if ( CErrCode::ERR_SUCCESS == $nErrCode )
		{
			if ( $oClient instanceof OssClient )
			{
				try
				{
					$infoRtn = $oClient->uploadFile( $sBucketName, $sFileName, $sFilePath );

					if ( is_null( $infoRtn ) )
					{
						$nErrCode = CErrCode::ERR_SUCCESS;
					}
					else
					{
						$nErrCode = CErrCode::ERR_OSS_UPLOAD_FAIL;
					}
				}
				catch( OssException $e )
				{
					$nErrCode = CErrCode::ERR_OSS_UPLOAD_EXCEPTION;
				}
			}
			else
			{
				$nErrCode = CErrCode::ERR_OSS_UPLOAD_CLIENT_ERR;
			}
		}

		return $nErrCode;
	}

	/**
	 * 查询指定对象在oss中是否存在
	 * $arrPara参数列表:
	 * <li> 'AccessKeyId' 		: [必需]请求accessKeyId参数
	 * <li> 'AccessKeySecret'	: [必需]请求accessKeySecret参数
	 * <li> 'useinner'          : [非必需]请求是否使用内网标识,默认CConst::CONST_DEFAULT_IF_USE_INNER;
	 * 							取值范围:CConst::CONST_NOT_USE_INNER,CConst::CONST_USE_INNER
	 * <li> 'timeout'			: [非必需]client请求超时时间,默认CConst::CONST_TIMEOUT
	 * <li> 'conntimeout'		: [非必需]client连接超时时间,默认CConst::CONST_CONN_TIMEOUT
	 * <li> 'bktinnerurl'		: [必需]请求bucket内网连接地址
	 * <li> 'bkturl'			: [必需]请求bucket外网连接地址
	 * <li> 'bucket'			: [必需]上传到的bucket名称
	 * <li> 'filename'			: [必需]上传的对象名称,如果存在相同名称的对象,则覆盖
	 * <li> 'SecurityToken'		: [非必需]使用token的accessKeyId及secret需要带此参数,参数为请求token中的原值
	 *
	 * @author wanganning
	 * @modify-log
	 *        name            date            reason
	 *        王安宁			2016-10-31			创建
	 *
	 * @param $arrPara		array		参数列表
	 * @param $bRtn			bool		是否存在
	 *
	 * @return int		错误码
	 */
	public static function doesObjectExists( $arrPara, & $bRtn )
	{
		if ( ! is_array( $arrPara ) )
		{
			return CErrCode::ERR_OSS_DOES_EXISTS_OBJECT_PARA_ARR;
		}

		$sBuckName = array_key_exists( 'bucket', $arrPara ) ? $arrPara[ 'bucket' ] : null;
		if ( ! is_string( $sBuckName ) || strlen( $sBuckName ) <= 0 )
		{
			return CErrCode::ERR_OSS_DOES_EXISTS_OBJECT_PARA_BUCKET;
		}

		$sFileName = array_key_exists( 'filename', $arrPara ) ? $arrPara[ 'filename' ] : null;
		if ( ! is_string( $sFileName ) || strlen( $sFileName ) <= 0 )
		{
			return CErrCode::ERR_OSS_DOES_EXISTS_OBJECT_PARA_FILENAME;
		}

		$nErrCode = CErrCode::ERR_UNKNOWN;

		$oClient = null;
		$nErrCode = self::getClient( $arrPara, $oClient );
		if ( CErrCode::ERR_SUCCESS == $nErrCode )
		{
			if ( $oClient instanceof OssClient )
			{
				try
				{
					$bRtn = $oClient->doesObjectExist( $sBuckName, $sFileName );
					$nErrCode = CErrCode::ERR_SUCCESS;
				}
				catch( OssException $e )
				{
					$nErrCode = CErrCode::ERR_OSS_DOES_EXISTS_OBJECT_EXCEPTION;
				}
			}
			else
			{
				$nErrCode = CErrCode::ERR_OSS_DOES_EXISTS_OBJECT_CLIENT;
			}
		}

		return $nErrCode;
	}


	/**
	 * 获得指定Oss对象
	 * $arrPara参数列表:
	 * <li> 'AccessKeyId' 		: [必需]请求accessKeyId参数
	 * <li> 'AccessKeySecret'	: [必需]请求accessKeySecret参数
	 * <li> 'useinner'          : [非必需]请求是否使用内网标识,默认CConst::CONST_DEFAULT_IF_USE_INNER;
	 * 							取值范围:CConst::CONST_NOT_USE_INNER,CConst::CONST_USE_INNER
	 * <li> 'timeout'			: [非必需]client请求超时时间,默认CConst::CONST_TIMEOUT
	 * <li> 'conntimeout'		: [非必需]client连接超时时间,默认CConst::CONST_CONN_TIMEOUT
	 * <li> 'bktinnerurl'		: [必需]请求bucket内网连接地址
	 * <li> 'bkturl'			: [必需]请求bucket外网连接地址
	 * <li> 'bucket'			: [必需]上传到的bucket名称
	 * <li> 'filename'			: [必需]上传的对象名称,如果存在相同名称的对象,则覆盖
	 * <li> 'SecurityToken'		: [非必需]使用token的accessKeyId及secret需要带此参数,参数为请求token中的原值
	 *
	 * @author wanganning
	 * @modify-log
	 *        name            date            reason
	 *        王安宁			2016-10-31			创建
	 *
	 * @param $arrPara		array		参数列表
	 * @param $sRtn			string		获得object返回值
	 *
	 * @return int		错误码
	 */
	public static function getObject( $arrPara, & $sRtn )
	{
		if ( ! is_array( $arrPara ) )
		{
			return CErrCode::ERR_OSS_GET_OSS_PARA_ARR;
		}

		$sBucketName = array_key_exists( 'bucket', $arrPara ) ? $arrPara[ 'bucket' ] : null;
		if ( ! is_string( $sBucketName ) || strlen( $sBucketName ) <= 0 )
		{
			return CErrCode::ERR_OSS_GET_OSS_PARA_BUCKET;
		}

		$sFileName = array_key_exists( 'filename', $arrPara ) ? $arrPara[ 'filename' ] : null;
		if ( ! is_string( $sFileName ) || strlen( $sFileName ) <= 0 )
		{
			return CErrCode::ERR_OSS_GET_OSS_PARA_FILE_NAME;
		}

		$nErrCode = CErrCode::ERR_UNKNOWN;

		$oClient = null;
		$nErrCode = self::getClient( $arrPara, $oClient );
		if ( CErrCode::ERR_SUCCESS == $nErrCode )
		{
			if ( $oClient instanceof OssClient )
			{
				try
				{
					$sRtn = $oClient->getObject( $sBucketName, $sFileName );
					if ( is_string( $sRtn ) && strlen( $sRtn ) > 0 )
					{
						$nErrCode = CErrCode::ERR_SUCCESS;
					}
					else
					{
						$nErrCode = CErrCode::ERR_OSS_GET_OSS_FAIL;
					}
				}
				catch( OssException $e )
				{
					$nErrCode = CErrCode::ERR_OSS_GET_OSS_EXCEPTION;
				}
			}
			else
			{
				$nErrCode = CErrCode::ERR_OSS_GET_OSS_CLIENT;
			}
		}

		return $nErrCode;
	}


	/**
	 * 获得图片访问连接
	 * $arrPara参数列表:
	 * <li> 'AccessKeyId' 		: [必需]请求accessKeyId参数
	 * <li> 'AccessKeySecret'	: [必需]请求accessKeySecret参数
	 * <li> 'timeout'			: [非必需]client请求超时时间,默认CConst::CONST_TIMEOUT
	 * <li> 'conntimeout'		: [非必需]client连接超时时间,默认CConst::CONST_CONN_TIMEOUT
	 * <li> 'imgurl'            : [必需]img正常访问域名
	 * <li> 'bucket'            : [必需]上传到的bucket名称
	 * <li> 'filename'			: [必需]上传的对象名称,如果存在相同名称的对象,则覆盖
	 * <li> 'validtime'			: [非必需]连接有效期,默认:60*60秒
	 *
	 * @author wanganning
	 * @modify-log
	 *        name            date            reason
	 *        王安宁			2016-10-31			创建
	 *
	 * @param $arrPara		array		参数列表
	 * @param $sRtn			string		返回的访问连接
	 *
	 * @return int
	 * @throws \OSS\Core\OssException
	 */
	public static function imgProcess( $arrPara, & $sRtn )
	{
		if ( ! is_array( $arrPara ) )
		{
			return CErrCode::ERR_OSS_GET_IMG_PROCESS_PARA_ARR;
		}

		$sBucket = array_key_exists( 'bucket', $arrPara ) ? $arrPara[ 'bucket' ] : null;
		if ( ! is_string( $sBucket ) || strlen( $sBucket ) <= 0 )
		{
			return CErrCode::ERR_OSS_GET_IMG_PROCESS_PARA_BUCKET;
		}

		$sFileName = array_key_exists( 'filename', $arrPara ) ? $arrPara[ 'filename' ] : null;
		if ( ! is_string( $sFileName ) || strlen( $sFileName ) <= 0 )
		{
			return CErrCode::ERR_OSS_GET_IMG_PROCESS_PARA_FILENAME;
		}

		$nValidTime = array_key_exists( 'validtime', $arrPara ) ? $arrPara[ 'validtime' ] : CConst::CONST_IMG_PROCESS_URL_VALID_TIME;
		if ( ! is_numeric( $nValidTime ) || $nValidTime <= 0 )
		{
			return CErrCode::ERR_OSS_GET_IMG_PROCESS_PARA_VALID_TIME;
		}

		$nErrCode = CErrCode::ERR_UNKNOWN;
		$oClient = null;
		$nErrCode = self::getClientWithImgInfo( $arrPara, $oClient );
		if ( CErrCode::ERR_SUCCESS == $nErrCode )
		{
			if ( $oClient instanceof OssClient )
			{
				try
				{
					$sRtn = $oClient->signUrl( $sBucket, $sFileName, $nValidTime );
					if ( is_string( $sRtn ) && strlen( $sRtn ) > 0 )
					{
						$nErrCode = CErrCode::ERR_SUCCESS;
					}
					else
					{
						$nErrCode = CErrCode::ERR_OSS_GET_IMG_PROCESS_SIGN_RTN;
					}
				}
				catch( OssException $e )
				{
					$nErrCode = CErrCode::ERR_OSS_GET_IMG_PROCESS_SIGN_EXCEPTION;
				}
			}
			else
			{
				$nErrCode = CErrCode::ERR_OSS_GET_IMG_PROCESS_GET_CLIENT;
			}
		}

		return $nErrCode;
	}


	/**
	 * 获得Oss连接请求对象
	 * $arrPara参数列表:
	 * <li> 'AccessKeyId' 		: [必需]请求accessKeyId参数
	 * <li> 'AccessKeySecret'	: [必需]请求accessKeySecret参数
	 * <li> 'useinner'          : [非必需]请求是否使用内网标识,默认CConst::CONST_DEFAULT_IF_USE_INNER;
	 * 							取值范围:CConst::CONST_NOT_USE_INNER,CConst::CONST_USE_INNER
	 * <li> 'timeout'			: [非必需]client请求超时时间,默认CConst::CONST_TIMEOUT
	 * <li> 'conntimeout'		: [非必需]client连接超时时间,默认CConst::CONST_CONN_TIMEOUT
	 * <li> 'bktinnerurl'		: [必需]请求bucket内网连接地址
	 * <li> 'bkturl'			: [必需]请求bucket外网连接地址
	 * <li> 'SecurityToken'		: [非必需]使用token的accessKeyId及secret需要带此参数,参数为请求token中的原值
	 *
	 * @author wanganning
	 * @modify-log
	 *        name            date            reason
	 *        王安宁			2016-10-31			创建
	 *
	 * @param           $arrPara		array		请求参数列表
	 * @param  			$oClientRtn		object		client实例或null
	 *
	 * @return int		 错误码
	 */
	public static function getClient( $arrPara, & $oClientRtn )
	{
		if ( ! is_array( $arrPara ) )
		{
			return CErrCode::ERR_OSS_GET_CLIENT_PARA_ARR;
		}

		$sAccessKeyId = array_key_exists( 'AccessKeyId', $arrPara ) ? $arrPara[ 'AccessKeyId' ] : null;
		if ( ! is_string( $sAccessKeyId )  || strlen( $sAccessKeyId ) <= 0 )
		{
			return CErrCode::ERR_OSS_GET_CLIENT_PARA_ACCESS_KEY_ID;
		}

		$sAccessKeySecret = array_key_exists( 'AccessKeySecret', $arrPara ) ? $arrPara[ 'AccessKeySecret' ] : null;
		if ( ! is_string( $sAccessKeySecret ) || strlen( $sAccessKeySecret ) <= 0 )
		{
			return CErrCode::ERR_OSS_GET_CLIENT_PARA_ACCESS_KEY_SECRET;
		}

		$nUseInner = array_key_exists( 'useinner', $arrPara ) ? $arrPara[ 'useinner' ] : CConst::CONST_DEFAULT_IF_USE_INNER;
		if ( ! is_numeric( $nUseInner ) )
		{
			return CErrCode::ERR_OSS_GET_CLIENT_PARA_USE_INNER;
		}

		$nTimeOut = array_key_exists( 'timeout', $arrPara ) ? $arrPara[ 'timeout' ] : CConst::CONST_TIMEOUT;
		if ( ! is_numeric( $nTimeOut ) || $nTimeOut <= 0 )
		{
			return CErrCode::ERR_OSS_GET_CLIENT_PARA_TIMEOUT;
		}

		$nConnTimeOut = array_key_exists( 'conntimeout', $arrPara ) ? $arrPara[ 'conntimeout' ] : CConst::CONST_CONN_TIMEOUT;
		if ( ! is_numeric( $nConnTimeOut ) || $nConnTimeOut <= 0 )
		{
			return CErrCode::ERR_OSS_GET_CLIENT_PARA_CONN_TIMEOUT;
		}

		$sBktInnerUrl = array_key_exists( 'bktinnerurl', $arrPara ) ? $arrPara[ 'bktinnerurl' ] : null;
		if ( ! is_string( $sBktInnerUrl ) || strlen( $sBktInnerUrl ) <= 0 )
		{
			return CErrCode::ERR_OSS_GET_CLIENT_PARA_BUCKET_INNER_URL;
		}

		$sBktUrl = array_key_exists( 'bkturl', $arrPara ) ? $arrPara[ 'bkturl' ] : null;
		if ( ! is_string( $sBktUrl ) || strlen( $sBktUrl ) <= 0 )
		{
			return CErrCode::ERR_OSS_GET_CLIENT_PARA_BUCKET_URL;
		}

		$sSecretToken = array_key_exists( 'SecurityToken', $arrPara ) ? $arrPara[ 'SecurityToken' ] : null;
		if ( ! is_null( $sSecretToken )
			&& ( ! is_string( $sSecretToken ) || strlen( $sSecretToken ) <= 0 )
		)
		{
			return CErrCode::ERR_OSS_GET_CLIENT_PARA_SECRET_TOKEN;
		}

		$nErrCode = CErrCode::ERR_UNKNOWN;

		$sEndPoint = '';
		if ( CConst::CONST_NOT_USE_INNER === $nUseInner )
		{
			$sEndPoint = $sBktUrl;
		}
		else
		{
			$sEndPoint = $sBktInnerUrl;
		}

		$oClientRtn = new OssClient( $sAccessKeyId, $sAccessKeySecret, $sEndPoint, false, $sSecretToken );
		$oClientRtn->setTimeout( $nTimeOut );
		$oClientRtn->setConnectTimeout( $nConnTimeOut );
		$nErrCode = CErrCode::ERR_SUCCESS;

		return $nErrCode;
	}


	/**
	 * 获得Oss连接请求对象
	 * $arrPara参数列表:
	 * <li> 'AccessKeyId' 		: [必需]请求accessKeyId参数
	 * <li> 'AccessKeySecret'	: [必需]请求accessKeySecret参数
	 * <li> 'timeout'			: [非必需]client请求超时时间,默认CConst::CONST_TIMEOUT
	 * <li> 'conntimeout'		: [非必需]client连接超时时间,默认CConst::CONST_CONN_TIMEOUT
	 * <li> 'imgurl'			: [必需]img正常访问域名
	 *
	 * @author wanganning
	 * @modify-log
	 *        name            date            reason
	 *        王安宁			2016-10-31			创建
	 *
	 * @param           $arrPara		array		请求参数列表
	 * @param  			$oClientRtn		object		client实例或null
	 *
	 * @return int		 错误码
	 */
	public static function getClientWithImgInfo( $arrPara, & $oClientRtn )
	{
		if ( ! is_array( $arrPara ) )
		{
			return CErrCode::ERR_OSS_GET_CLIENT_WITH_IMG_PARA_ARR;
		}

		$sAccessKeyId = array_key_exists( 'AccessKeyId', $arrPara ) ? $arrPara[ 'AccessKeyId' ] : null;
		if ( ! is_string( $sAccessKeyId )  || strlen( $sAccessKeyId ) <= 0 )
		{
			return CErrCode::ERR_OSS_GET_CLIENT_WITH_IMG_PARA_ACCESS_KEY_ID;
		}

		$sAccessKeySecret = array_key_exists( 'AccessKeySecret', $arrPara ) ? $arrPara[ 'AccessKeySecret' ] : null;
		if ( ! is_string( $sAccessKeySecret ) || strlen( $sAccessKeySecret ) <= 0 )
		{
			return CErrCode::ERR_OSS_GET_CLIENT_WITH_IMG_PARA_ACCESS_KEY_SECRET;
		}

		$nTimeOut = array_key_exists( 'timeout', $arrPara ) ? $arrPara[ 'timeout' ] : CConst::CONST_TIMEOUT;
		if ( ! is_numeric( $nTimeOut ) || $nTimeOut <= 0 )
		{
			return CErrCode::ERR_OSS_GET_CLIENT_WITH_IMG_PARA_TIMEOUT;
		}

		$nConnTimeOut = array_key_exists( 'conntimeout', $arrPara ) ? $arrPara[ 'conntimeout' ] : CConst::CONST_CONN_TIMEOUT;
		if ( ! is_numeric( $nConnTimeOut ) || $nConnTimeOut <= 0 )
		{
			return CErrCode::ERR_OSS_GET_CLIENT_WITH_IMG_PARA_CONN_TIMEOUT;
		}

		$sImgUrl = array_key_exists( 'imgurl', $arrPara ) ? $arrPara[ 'imgurl' ] : null;
		if ( ! is_string( $sImgUrl ) || strlen( $sImgUrl ) <= 0 )
		{
			return CErrCode::ERR_OSS_GET_CLIENT_WITH_IMG_PARA_IMG_URL;
		}

		$nErrCode = CErrCode::ERR_UNKNOWN;

		$sEndPoint = $sImgUrl;
		$oClientRtn = new OssClient( $sAccessKeyId, $sAccessKeySecret, $sEndPoint, true );
		$oClientRtn->setTimeout( $nTimeOut );
		$oClientRtn->setConnectTimeout( $nConnTimeOut );
		$nErrCode = CErrCode::ERR_SUCCESS;

		return $nErrCode;
	}


	//////////////////////////////////////////////////////////////////////////////////
	////  Private
	////
	//
	///**
	// * 对象初始化类
	// *
	// * @author wanganning
	// * @modify-log
	// *        name            date            reason
	// *        王安宁
	// *
	// * @param $arrConfig
	// */
	//private function _Init( $arrConfig )
	//{
	//	//初始化OSS，生成oss对象
	//	//include_once dirname(__FILE__).'/Config.php';
	//	if(is_array( $arrConfig ) && count( $arrConfig ) > 0 )
	//	{
	//		//dd($aliyunConfig);
	//		$this->accessKeyId          =   array_key_exists( 'accesskeyid', $arrConfig ) ? $arrConfig['accesskeyid'] : null;
	//		$this->accessKeySecret      =   array_key_exists( 'accesskeysecret', $arrConfig ) ? $arrConfig[ 'accesskeysecret' ] : null;
	//		$this->bucket               =   array_key_exists( 'bucket', $arrConfig ) ? $arrConfig['bucket'] : null;
	//		$this->ossServerInternal	=	array_key_exists( 'ossserverinternal', $arrConfig ) ? $arrConfig[ 'ossserverinternal' ] : null;
	//		$this->ossServer			=	array_key_exists( 'ossserver', $arrConfig ) ? $arrConfig[ 'ossserver' ] : null;
	//		$this->endPoint             =   $this->_isInner() ? $this->ossServerInternal : $this->ossServer;
	//		$this->stsServer            =   array_key_exists( 'stsserver', $arrConfig ) ? $arrConfig[ 'e' ] : null;
	//		$this->sonAccessKeyId       =   array_key_exists( 'sonaccesskeyid', $arrConfig ) ? $arrConfig[ 'sonaccesskeyid' ] : null;
	//		$this->sonAccessKeySecret   =   array_key_exists( 'sonaccesskeysecret', $arrConfig ) ? $arrConfig[ 'sonaccesskeysecret' ] : null;
	//		// 角色资源描述符，在RAM的控制台的资源详情页上可以获取
	//		$this->roleArn              =   array_key_exists( 'writerolearn', $arrConfig ) ? $arrConfig[ 'writerolearn' ] : null;
	//		$this->tokeneffectivetime   =   array_key_exists( 'tokeneffectivetime', $arrConfig ) ? $arrConfig[ 'tokeneffectivetime' ] : null;
	//		$this->client               =   new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endPoint);
	//		$this->client->setTimeout(5);
	//		$this->client->setConnectTimeout(20);
	//	}
	//}

	////检查是否是内网
	//private function _isInner()
	//{
	//	return false;
	//}


	//protected $client               =   "";
	//protected $accessKeyId          =   "";
	//protected $accessKeySecret      =   "";
	//protected $endPoint             =   "";
	//protected $bucket               =   "";
	//protected $stsServer            =   "";
	//protected $sonAccessKeyId       =   "";
	//protected $sonAccessKeySecret   =   "";
	//protected $roleArn              =   "";
	//protected $tokeneffectivetime   =   "";
	//
	//private   $ossServer            = 'http://oss-cn-beijing.aliyuncs.com';
	//private   $ossServerInternal    = 'http://oss-cn-beijing-internal.aliyuncs.com';
	//private   $imgServer            = 'http://img-cn-beijing.aliyuncs.com';

	//protected static $instance;


	//private function __clone(){}

	//public function __construct( $arrConfig )
	//{
	//	$this->_Init( $arrConfig );
	//}
	//
	//public static function getInstance( $arrConfig )
	//{
	//	if ( null == self::$instance || ! isset( self::$instance ) || ! self::$instance instanceof self )
	//	{
	//		self::$instance = new self( $arrConfig );
	//	}
	//	return self::$instance;
	//}

	//public function getUrl($sOssKey , $nTimeout = 60 , $Bucket = NULL)
	//{
	//	$Bucket = is_null($Bucket) ? self::$instance->bucket : $Bucket;
	//	$options = [
	//		'ResponseContentType' => 'image/jpeg',
	//		'ResponseContentDisposition' => 'image/jpeg'
	//	];
	//	//$myClient->EndPoint = \Config::get('app.imgServer');
	//	//$myClient->Client = new OssClient($myClient->AccessKeyId,$myClient->AccessKeySecret,$myClient->EndPoint);
	//	return self::$instance->client->signUrl($Bucket , $sOssKey , $nTimeout,'GET', $options);
	//}


	//public function PutToOSS( $sObject,$Content , $Options = NULL,$Bucket = NULL )
	//{
	//	$Bucket = is_null($Bucket) ? self::$instance->bucket : $Bucket;
	//	return self::$instance->Client->putObject( $Bucket , $sObject , $Content, $Options );
	//}
	//
	//public function deleteObjectFromOSS( $sOssKey ,$Options = NULL ,$Bucket = NULL)
	//{
	//	$Bucket = is_null($Bucket) ? self::$instance->bucket : $Bucket;
	//	return self::$instance->Client->deleteObject( $Bucket , $sOssKey , $Options );
	//}
	//
	//public function deleteObjectsFromOSS( $arrOssKeys ,$Options = NULL ,$Bucket = NULL)
	//{
	//	$Bucket = is_null($Bucket) ? self::$instance->bucket : $Bucket;
	//	return self::$instance->Client->deleteObjects( $Bucket , $arrOssKeys , $Options );
	//}
}