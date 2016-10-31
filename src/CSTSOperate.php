<?php
namespace dekuan\deoss;

use Sts\Request\V20150401 as Sts;

class CSTSOperate
{
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

		if ( ! array_key_exists( CConst::CONST_KEY_STS_SERVER, $arrConfig )
			|| ! is_string( $arrConfig [ CConst::CONST_KEY_STS_SERVER ] )
		)
		{
			return CErrCode::ERR_STS_GET_TOKEN_CONFIG_STS_SERVER;
		}

		if ( ! array_key_exists( CConst::CONST_KEY_ACCESS_KEY_ID, $arrConfig )
			|| ! is_string( $arrConfig[ CConst::CONST_KEY_ACCESS_KEY_ID ] )
		)
		{
			return CErrCode::ERR_STS_GET_TOKEN_CONFIG_ACCESS_KEY_ID;
		}

		if ( ! array_key_exists( CConst::CONST_KEY_ACCESS_KEY_SECRET, $arrConfig )
			|| ! is_string( $arrConfig[ CConst::CONST_KEY_ACCESS_KEY_SECRET ] )
		)
		{
			return CErrCode::ERR_STS_GET_TOKEN_CONFIG_ACCESS_KEY_SECRET;
		}

		if ( ! array_key_exists( CConst::CONST_KEY_ROLEARN, $arrConfig )
			|| ! is_string( $arrConfig[ CConst::CONST_KEY_ROLEARN ] )
		)
		{
			return CErrCode::ERR_STS_GET_TOKEN_CONFIG_ROLEARN;
		}

		if ( ! array_key_exists( CConst::CONST_KEY_TOKEN_EFFECTIVE_TIME, $arrConfig )
			|| ! is_numeric( $arrConfig[ CConst::CONST_KEY_TOKEN_EFFECTIVE_TIME ] )
		)
		{
			return CErrCode::ERR_STS_GET_TOKEN_CONFIG_TOKEN_EFFECTIVE_TIME;
		}

		$sPolicy = array_key_exists( CConst::CONST_KEY_POLICY, $arrConfig ) ? $arrConfig[ CConst::CONST_KEY_POLICY ] : null;
		if ( ! is_string( $sPolicy ) || strlen( $sPolicy ) <= 0 )
		{
			return CErrCode::ERR_STS_GET_POLICY;
		}

		$nErrCode = CErrCode::ERR_UNKNOWN;

		$sStsServer 			= $arrConfig[ CConst::CONST_KEY_STS_SERVER ];
		$sAccessKeyId 			= $arrConfig[ CConst::CONST_KEY_ACCESS_KEY_ID ];
		$sAccessKeySecret		= $arrConfig[ CConst::CONST_KEY_ACCESS_KEY_SECRET ];
		// 角色资源描述符，在RAM的控制台的资源详情页上可以获取
		$sRoleArn 				= $arrConfig[ CConst::CONST_KEY_ROLEARN ];
		$nTokenEffectiveTime	= $arrConfig[ CConst::CONST_KEY_TOKEN_EFFECTIVE_TIME ];

		$oClientProfile = \DefaultProfile::getProfile( $sStsServer, $sAccessKeyId, $sAccessKeySecret );
		$oClient = new \DefaultAcsClient( $oClientProfile );
		$request = new Sts\AssumeRoleRequest();
		$request->setRoleSessionName( $sClientName );
		$request->setRoleArn( $sRoleArn );
		$request->setPolicy( $sPolicy );
		$request->setDurationSeconds( $nTokenEffectiveTime );
		$response = $oClient->doAction($request);

		if ( is_array( $response ) )
		{
			$arrRtn = $response;
			$nErrCode = CErrCode::ERR_SUCCESS;
		}
		else
		{
			$nErrCode = CErrCode::ERR_STS_GET_TOKEN_RESPONSE;
		}

		return $nErrCode;
	}
}

