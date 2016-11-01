<?php
namespace dekuan\deoss;

use OSS\Core\OssException;
use Sts\Request\V20150401 as Sts;
use HttpResponse;

class CSTSOperate
{

	/**
	 * 获得Oss操作token
	 * $arrConfig参数表
	 * <li> 'stsserver'			: sts服务地址
	 * <li> 'accesskeyid'		: accessKeyId,ali云访问控制管理中创建的用户对应的accessKeyId
	 * <li> 'accesskeysecret'	: accessKeySecret,ali云raw管理中创建的accessKeyId对应的accessKeySecret
	 * <li> 'rolearn'			: 角色资源描述符，在RAM的控制台的资源详情页上可以获取
	 * <li> 'tokeneffectivetime': token有效期
	 * <li> 'policy'			: 创建的accessKeyId对应的用户授权策略
	 *
	 * @author wanganning
	 * @modify-log
	 *        name            date            reason
	 *        王安宁			2016-10-31			创建
	 *
	 * @param $sClientName
	 * @param $arrConfig		array		参数数组
	 * @param $arrRtn			array		返回的token数组
	 *
	 * @return int			错误码
	 * @throws \ClientException
	 */
	public static function getToken( $sClientName, $arrConfig, & $arrRtn )
	{
		include_once dirname(__FILE__) . '/../lib/aliyun-php-sdk-core/Config.php';

		if ( ! is_string( $sClientName ) || strlen( $sClientName ) <= 0 )
		{
			return CErrCode::ERR_STS_GET_TOKEN_CLIENT_NAME;
		}

		if ( ! is_array( $arrConfig ) )
		{
			return CErrCode::ERR_STS_GET_TOKEN_ARR_CONFIG;
		}

		$sStsServer = array_key_exists( CConst::CONST_KEY_STS_SERVER, $arrConfig ) ? $arrConfig[ CConst::CONST_KEY_STS_SERVER ] : null;
		if ( ! is_string( $sStsServer ) || strlen( $sStsServer ) <= 0 )
		{
			return CErrCode::ERR_STS_GET_TOKEN_CONFIG_STS_SERVER;
		}

		$sAccessKeyId = array_key_exists( CConst::CONST_KEY_ACCESS_KEY_ID, $arrConfig ) ? $arrConfig[ CConst::CONST_KEY_ACCESS_KEY_ID ] : null;
		if ( ! is_string( $sAccessKeyId ) || strlen( $sAccessKeyId ) <= 0 )
		{
			return CErrCode::ERR_STS_GET_TOKEN_CONFIG_ACCESS_KEY_ID;
		}

		$sAccessKeySecret = array_key_exists( CConst::CONST_KEY_ACCESS_KEY_SECRET, $arrConfig ) ?
			$arrConfig[ CConst::CONST_KEY_ACCESS_KEY_SECRET ] : null;
		if ( ! is_string( $sAccessKeySecret ) || strlen( $sAccessKeySecret ) <= 0 )
		{
			return CErrCode::ERR_STS_GET_TOKEN_CONFIG_ACCESS_KEY_SECRET;
		}

		// 角色资源描述符，在RAM的控制台的资源详情页上可以获取
		$sRoleArn = array_key_exists( CConst::CONST_KEY_ROLEARN, $arrConfig ) ? $arrConfig[ CConst::CONST_KEY_ROLEARN ] : null;
		if ( ! is_string( $sRoleArn ) || strlen( $sRoleArn ) <= 0 )
		{
			return CErrCode::ERR_STS_GET_TOKEN_CONFIG_ROLEARN;
		}

		$nTokenEffectiveTime = array_key_exists( CConst::CONST_KEY_TOKEN_EFFECTIVE_TIME, $arrConfig ) ?
			$arrConfig[ CConst::CONST_KEY_TOKEN_EFFECTIVE_TIME ] : null;
		if ( ! is_numeric( $nTokenEffectiveTime ) || $nTokenEffectiveTime <= 0 )
		{
			return CErrCode::ERR_STS_GET_TOKEN_CONFIG_TOKEN_EFFECTIVE_TIME;
		}

		$sPolicy = array_key_exists( CConst::CONST_KEY_POLICY, $arrConfig ) ? $arrConfig[ CConst::CONST_KEY_POLICY ] : null;
		if ( ! is_string( $sPolicy ) || strlen( $sPolicy ) <= 0 )
		{
			return CErrCode::ERR_STS_GET_POLICY;
		}

		$nErrCode = CErrCode::ERR_UNKNOWN;

		$oClientProfile = \DefaultProfile::getProfile( $sStsServer, $sAccessKeyId, $sAccessKeySecret );
		$oClient = new \DefaultAcsClient( $oClientProfile );
		$request = new Sts\AssumeRoleRequest();
		$request->setRoleSessionName( $sClientName );
		$request->setRoleArn( $sRoleArn );
		$request->setPolicy( $sPolicy );
		$request->setDurationSeconds( $nTokenEffectiveTime );
		try
		{
			$response = $oClient->doAction($request);
			if ( $response && $response instanceof HttpResponse )
			{
				$sBody = $response->getBody();
				if ( is_string( $sBody ) )
				{
					$arrRtn = @json_decode( $sBody, true );
					$nErrCode = CErrCode::ERR_SUCCESS;
				}
				else
				{
					$nErrCode = CErrCode::ERR_STS_GET_TOKEN_RESPONSE_BODY;
				}
			}
			else
			{
				$nErrCode = CErrCode::ERR_STS_GET_TOKEN_RESPONSE;
			}
		}
		catch( OssException $e )
		{
			$nErrCode = CErrCode::ERR_STS_GET_TOKEN_EXCEPTION;
		}

		return $nErrCode;
	}
}

