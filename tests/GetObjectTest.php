<?php

require_once ( __DIR__ . '/TestBase.php' );

define( 'GetObjectTestSkip', 1 );

class GetObjectTest extends TestBase {
	public function testGetObject()
	{
		$this->skipTest( GetObjectTestSkip );
		$sTestName = '从oss上获得对象信息';
		$arrConfig = $this->getDefaultConfig();

		$arrTmpToken[ 'AccessKeyId' ] = $arrConfig[ 'accesskeyid' ];
		$arrTmpToken[ 'AccessKeySecret' ] = $arrConfig[ 'accesskeysecret' ];
		$arrTmpToken[ 'bktinnerurl' ] = $arrConfig[ 'ossserverinternal' ];
		$arrTmpToken[ 'bkturl' ] = $arrConfig[ 'ossserver' ];
		$arrTmpToken[ 'useinner' ] = \dekuan\deoss\CConst::CONST_NOT_USE_INNER;
		$arrTmpToken[ 'bucket' ] = 'deimage';
		$arrTmpToken[ 'filename' ] = 'test.jpg';		//	存在

		$sRtn = null;
		$nErrCode = \dekuan\deoss\COSSOperate::getObject( $arrTmpToken, $sRtn );
		if ( 0 == $nErrCode )
		{
			if ( is_string( $sRtn ) && strlen( $sRtn ) > 0 )
			{
				$this->echoTestResult( true, $sTestName );
			}
			else
			{
				$this->echoTestResult( false, $sTestName, '获得object返回值验证失败' );
			}
		}
		else
		{
			$this->echoTestResult( false, $sTestName, '获得object失败,错误码:' . $nErrCode );
		}


		$arrTmpToken[ 'filename' ] = 'test2.jpg';		//	不存在

		$sRtn = null;
		$nErrCode = \dekuan\deoss\COSSOperate::getObject( $arrTmpToken, $sRtn );
		if ( \dekuan\deoss\CErrCode::ERR_OSS_GET_OSS_EXCEPTION == $nErrCode )
		{
			$this->echoTestResult( true, $sTestName );
		}
		else
		{
			$this->echoTestResult( false, $sTestName, '获得object预期错误,错误码:' . $nErrCode );
		}

		$arrTmpToken[ 'filename' ] = '15191418717';		//	存在
		$sRtn = null;
		$nErrCode = \dekuan\deoss\COSSOperate::getObject( $arrTmpToken, $sRtn );
		if ( 0 == $nErrCode )
		{
			if ( is_string( $sRtn ) && strlen( $sRtn ) > 0 )
			{
				$this->echoTestResult( true, $sTestName );
			}
			else
			{
				$this->echoTestResult( false, $sTestName, '获得object返回值验证失败' );
			}
		}
		else
		{
			$this->echoTestResult( false, $sTestName, '获得object失败,错误码:' . $nErrCode );
		}
	}


	public function testGetObjectWithDir()
	{
		$this->skipTest( GetObjectTestSkip );
		$sTestName = '从oss 文件夹上获得对象信息';
		$arrConfig = $this->getDefaultConfig();

		$arrTmpToken[ 'AccessKeyId' ] = $arrConfig[ 'accesskeyid' ];
		$arrTmpToken[ 'AccessKeySecret' ] = $arrConfig[ 'accesskeysecret' ];
		$arrTmpToken[ 'bktinnerurl' ] = $arrConfig[ 'ossserverinternal' ];
		$arrTmpToken[ 'bkturl' ] = $arrConfig[ 'ossserver' ];
		$arrTmpToken[ 'useinner' ] = \dekuan\deoss\CConst::CONST_NOT_USE_INNER;
		$arrTmpToken[ 'bucket' ] = 'deimage';
		$arrTmpToken[ 'filename' ] = 'user/test.jpg';		//	存在

		$sRtn = null;
		$nErrCode = \dekuan\deoss\COSSOperate::getObject( $arrTmpToken, $sRtn );
		if ( 0 == $nErrCode )
		{
			if ( is_string( $sRtn ) && strlen( $sRtn ) > 0 )
			{
				$this->echoTestResult( true, $sTestName );
			}
			else
			{
				$this->echoTestResult( false, $sTestName, '获得object返回值验证失败' );
			}
		}
		else
		{
			$this->echoTestResult( false, $sTestName, '获得object失败,错误码:' . $nErrCode );
		}
	}

	public function testGetObjectWithToken()
	{
		$this->skipTest( GetObjectTestSkip );
		$sTestName = '使用token从oss上获得对象信息';
		$arrConfig = $this->getDefaultConfig();

		$arrToken = [];
		$nErrCode = \dekuan\deoss\CSTSOperate::getToken( '1234567890', $arrConfig, $arrToken );

		if ( 0 == $nErrCode )
		{
			if ( ( is_array( $arrToken ) && array_key_exists( 'Credentials', $arrToken ) ) )
			{
				$arrTmpToken = $arrToken[ 'Credentials' ];
				$arrTmpToken[ 'bktinnerurl' ] = $arrConfig[ 'ossserverinternal' ];
				$arrTmpToken[ 'bkturl' ] = $arrConfig[ 'ossserver' ];
				$arrTmpToken[ 'useinner' ] = \dekuan\deoss\CConst::CONST_NOT_USE_INNER;
				$arrTmpToken[ 'bucket' ] = 'deimage';
				$arrTmpToken[ 'filename' ] = 'test.jpg';		//	存在

				$sRtn = null;
				$nErrCode = \dekuan\deoss\COSSOperate::getObject( $arrTmpToken, $sRtn );
				if ( 0 == $nErrCode )
				{
					if ( is_string( $sRtn ) && strlen( $sRtn ) > 0 )
					{
						$this->echoTestResult( true, $sTestName );
					}
					else
					{
						$this->echoTestResult( false, $sTestName, '获得object返回值验证失败' );
					}
				}
				else
				{
					$this->echoTestResult( false, $sTestName, '获得object失败,错误码:' . $nErrCode );
				}


				$arrTmpToken[ 'filename' ] = 'test2.jpg';		//	不存在

				$sRtn = null;
				$nErrCode = \dekuan\deoss\COSSOperate::getObject( $arrTmpToken, $sRtn );
				if ( \dekuan\deoss\CErrCode::ERR_OSS_GET_OSS_EXCEPTION == $nErrCode )
				{
					$this->echoTestResult( true, $sTestName );
				}
				else
				{
					$this->echoTestResult( false, $sTestName, '获得object预期错误,错误码:' . $nErrCode );
				}
			}
			else
			{
				$this->echoTestResult( false, $sTestName, 'token验证失败' );
			}
		}
		else
		{
			$this->echoTestResult( false, $sTestName, 'token获取失败' );
		}
	}

	public function testGetObjectWithTokenReadPolicy()
	{
		$this->skipTest( GetObjectTestSkip );
		$sTestName = '使用read token从oss上获得对象信息';
		$arrConfig = $this->getReadConfig();

		$arrToken = [];
		$nErrCode = \dekuan\deoss\CSTSOperate::getToken( '1234567890', $arrConfig, $arrToken );

		if ( 0 == $nErrCode )
		{
			if ( ( is_array( $arrToken ) && array_key_exists( 'Credentials', $arrToken ) ) )
			{
				$arrTmpToken = $arrToken[ 'Credentials' ];
				$arrTmpToken[ 'bktinnerurl' ] = $arrConfig[ 'ossserverinternal' ];
				$arrTmpToken[ 'bkturl' ] = $arrConfig[ 'ossserver' ];
				$arrTmpToken[ 'useinner' ] = \dekuan\deoss\CConst::CONST_NOT_USE_INNER;
				$arrTmpToken[ 'bucket' ] = 'deimage';
				$arrTmpToken[ 'filename' ] = 'test.jpg';		//	存在

				$sRtn = null;
				$nErrCode = \dekuan\deoss\COSSOperate::getObject( $arrTmpToken, $sRtn );
				if ( 0 == $nErrCode )
				{
					if ( is_string( $sRtn ) && strlen( $sRtn ) > 0 )
					{
						$this->echoTestResult( true, $sTestName );
					}
					else
					{
						$this->echoTestResult( false, $sTestName, '获得object返回值验证失败' );
					}
				}
				else
				{
					$this->echoTestResult( false, $sTestName, '获得object失败,错误码:' . $nErrCode );
				}


				$arrTmpToken[ 'filename' ] = 'test2.jpg';		//	不存在

				$sRtn = null;
				$nErrCode = \dekuan\deoss\COSSOperate::getObject( $arrTmpToken, $sRtn );
				if ( \dekuan\deoss\CErrCode::ERR_OSS_GET_OSS_EXCEPTION == $nErrCode )
				{
					$this->echoTestResult( true, $sTestName );
				}
				else
				{
					$this->echoTestResult( false, $sTestName, '获得object预期错误,错误码:' . $nErrCode );
				}
			}
			else
			{
				$this->echoTestResult( false, $sTestName, 'token验证失败' );
			}
		}
		else
		{
			$this->echoTestResult( false, $sTestName, 'token获取失败' );
		}
	}
}

