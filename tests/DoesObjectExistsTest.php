<?php

require_once( __DIR__ . "/TestBase.php" );

define( 'DoesObjectExistsTestSkip', 1 );

class DoesObjectExistsTest extends TestBase {
	public function testDoesObjectExists()
	{
		$this->skipTest( DoesObjectExistsTestSkip );
		$sTestName = '验证object在oss是否存在';
		$arrConfig = $this->getDefaultConfig();

		$arrTmpToken[ 'AccessKeyId' ] = $arrConfig[ 'accesskeyid' ];
		$arrTmpToken[ 'AccessKeySecret' ] = $arrConfig[ 'accesskeysecret' ];
		$arrTmpToken[ 'bktinnerurl' ] = $arrConfig[ 'ossserverinternal' ];
		$arrTmpToken[ 'bktinnerurl' ] = $arrConfig[ 'ossserverinternal' ];
		$arrTmpToken[ 'bkturl' ] = $arrConfig[ 'ossserver' ];
		$arrTmpToken[ 'useinner' ] = \dekuan\deoss\CConst::CONST_NOT_USE_INNER;
		$arrTmpToken[ 'bucket' ] = 'deimage';
		$arrTmpToken[ 'filename' ] = 'test1.jpg';		//	存在

		$bRtn = false;
		$nErrCode = \dekuan\deoss\COSSOperate::doesObjectExists( $arrTmpToken, $bRtn );
		if ( 0 == $nErrCode )
		{
			if ( $bRtn )
			{
				$this->echoTestResult( true, $sTestName );
			}
			else
			{
				$this->echoTestResult( false, $sTestName, '验证结果与预期不符' );
			}
		}
		else
		{
			$this->echoTestResult( false, $sTestName, '验证失败,错误码:' . $nErrCode );
		}

		$arrTmpToken[ 'filename' ] = 'test2.jpg';		//	不存在
		$bRtn = false;
		$nErrCode = \dekuan\deoss\COSSOperate::doesObjectExists( $arrTmpToken, $bRtn );
		if ( 0 == $nErrCode )
		{
			if ( ! $bRtn )
			{
				$this->echoTestResult( true, $sTestName );
			}
			else
			{
				$this->echoTestResult( false, $sTestName, '验证结果与预期不符' );
			}
		}
		else
		{
			$this->echoTestResult( false, $sTestName, '验证失败,错误码:' . $nErrCode );
		}

		$arrTmpToken[ 'filename' ] = '15191418717';		//	不存在
		$bRtn = false;
		$nErrCode = \dekuan\deoss\COSSOperate::doesObjectExists( $arrTmpToken, $bRtn );
		if ( 0 == $nErrCode )
		{
			if ( $bRtn )
			{
				$this->echoTestResult( true, $sTestName );
			}
			else
			{
				$this->echoTestResult( false, $sTestName, '验证结果与预期不符' );
			}
		}
		else
		{
			$this->echoTestResult( false, $sTestName, '验证失败,错误码:' . $nErrCode );
		}
	}


	public function testDoesObjectExistsWithDir()
	{
		$this->skipTest( DoesObjectExistsTestSkip );
		$sTestName = '验证object在oss 文件夹中是否存在';
		$arrConfig = $this->getDefaultConfig();

		$arrTmpToken[ 'AccessKeyId' ] = $arrConfig[ 'accesskeyid' ];
		$arrTmpToken[ 'AccessKeySecret' ] = $arrConfig[ 'accesskeysecret' ];
		$arrTmpToken[ 'bktinnerurl' ] = $arrConfig[ 'ossserverinternal' ];
		$arrTmpToken[ 'bktinnerurl' ] = $arrConfig[ 'ossserverinternal' ];
		$arrTmpToken[ 'bkturl' ] = $arrConfig[ 'ossserver' ];
		$arrTmpToken[ 'useinner' ] = \dekuan\deoss\CConst::CONST_NOT_USE_INNER;
		$arrTmpToken[ 'bucket' ] = 'deimage';
		$arrTmpToken[ 'filename' ] = 'user/test.jpg';		//	存在

		$bRtn = false;
		$nErrCode = \dekuan\deoss\COSSOperate::doesObjectExists( $arrTmpToken, $bRtn );
		if ( 0 == $nErrCode )
		{
			if ( $bRtn )
			{
				$this->echoTestResult( true, $sTestName );
			}
			else
			{
				$this->echoTestResult( false, $sTestName, '验证结果与预期不符' );
			}
		}
		else
		{
			$this->echoTestResult( false, $sTestName, '验证失败,错误码:' . $nErrCode );
		}

		$arrTmpToken[ 'filename' ] = 'user/test2.jpg';		//	不存在
		$bRtn = false;
		$nErrCode = \dekuan\deoss\COSSOperate::doesObjectExists( $arrTmpToken, $bRtn );
		if ( 0 == $nErrCode )
		{
			if ( ! $bRtn )
			{
				$this->echoTestResult( true, $sTestName );
			}
			else
			{
				$this->echoTestResult( false, $sTestName, '验证结果与预期不符' );
			}
		}
		else
		{
			$this->echoTestResult( false, $sTestName, '验证失败,错误码:' . $nErrCode );
		}

		$arrTmpToken[ 'filename' ] = '15191418717';		//	不存在
		$bRtn = false;
		$nErrCode = \dekuan\deoss\COSSOperate::doesObjectExists( $arrTmpToken, $bRtn );
		if ( 0 == $nErrCode )
		{
			if ( $bRtn )
			{
				$this->echoTestResult( true, $sTestName );
			}
			else
			{
				$this->echoTestResult( false, $sTestName, '验证结果与预期不符' );
			}
		}
		else
		{
			$this->echoTestResult( false, $sTestName, '验证失败,错误码:' . $nErrCode );
		}
	}

	public function testDoesObjectExistsWithToken()
	{
		$this->skipTest( DoesObjectExistsTestSkip );
		$sTestName = '使用token验证object在oss是否存在';

		$arrConfig = $this->getDefaultConfig();

		$arrToken = [];
		$nErrCode = \dekuan\deoss\CSTSOperate::getToken( '1234567890', $arrConfig, $arrToken );

		if ( 0 == $nErrCode )
		{
			if ( ( is_array( $arrToken ) && array_key_exists( 'Credentials', $arrToken ) ) )
			{
				$arrTmpToken = $arrToken[ 'Credentials' ];
				$arrTmpToken[ 'bktinnerurl' ] = $arrConfig[ 'ossserverinternal' ];
				$arrTmpToken[ 'bktinnerurl' ] = $arrConfig[ 'ossserverinternal' ];
				$arrTmpToken[ 'bkturl' ] = $arrConfig[ 'ossserver' ];
				$arrTmpToken[ 'useinner' ] = \dekuan\deoss\CConst::CONST_NOT_USE_INNER;
				$arrTmpToken[ 'bucket' ] = 'deimage';
				$arrTmpToken[ 'filename' ] = 'test1.jpg';		//	存在

				$bRtn = false;
				$nErrCode = \dekuan\deoss\COSSOperate::doesObjectExists( $arrTmpToken, $bRtn );
				if ( 0 == $nErrCode )
				{
					if ( $bRtn )
					{
						$this->echoTestResult( true, $sTestName );
					}
					else
					{
						$this->echoTestResult( false, $sTestName, '验证结果与预期不符' );
					}
				}
				else
				{
					$this->echoTestResult( false, $sTestName, '验证失败,错误码:' . $nErrCode );
				}

				$arrTmpToken[ 'filename' ] = 'test2.jpg';		//	不存在
				$bRtn = false;
				$nErrCode = \dekuan\deoss\COSSOperate::doesObjectExists( $arrTmpToken, $bRtn );
				if ( 0 == $nErrCode )
				{
					if ( ! $bRtn )
					{
						$this->echoTestResult( true, $sTestName );
					}
					else
					{
						$this->echoTestResult( false, $sTestName, '验证结果与预期不符' );
					}
				}
				else
				{
					$this->echoTestResult( false, $sTestName, '验证失败,错误码:' . $nErrCode );
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

	public function testDoesObjectExistsWithReadToken()
	{
		$this->skipTest( DoesObjectExistsTestSkip );
		$sTestName = '使用只有读权限token验证object在oss是否存在';

		$arrConfig = $this->getReadConfig();

		$arrToken = [];
		$nErrCode = \dekuan\deoss\CSTSOperate::getToken( '1234567890', $arrConfig, $arrToken );

		if ( 0 == $nErrCode )
		{
			if ( ( is_array( $arrToken ) && array_key_exists( 'Credentials', $arrToken ) ) )
			{
				$arrTmpToken = $arrToken[ 'Credentials' ];
				$arrTmpToken[ 'bktinnerurl' ] = $arrConfig[ 'ossserverinternal' ];
				$arrTmpToken[ 'bktinnerurl' ] = $arrConfig[ 'ossserverinternal' ];
				$arrTmpToken[ 'bkturl' ] = $arrConfig[ 'ossserver' ];
				$arrTmpToken[ 'useinner' ] = \dekuan\deoss\CConst::CONST_NOT_USE_INNER;
				$arrTmpToken[ 'bucket' ] = 'deimage';
				$arrTmpToken[ 'filename' ] = 'test1.jpg';		//	存在

				$bRtn = false;
				$nErrCode = \dekuan\deoss\COSSOperate::doesObjectExists( $arrTmpToken, $bRtn );
				if ( 0 == $nErrCode )
				{
					if ( $bRtn )
					{
						$this->echoTestResult( true, $sTestName );
					}
					else
					{
						$this->echoTestResult( false, $sTestName, '验证结果与预期不符' );
					}
				}
				else
				{
					$this->echoTestResult( false, $sTestName, '验证失败,错误码:' . $nErrCode );
				}

				$arrTmpToken[ 'filename' ] = 'test2.jpg';		//	不存在
				$bRtn = false;
				$nErrCode = \dekuan\deoss\COSSOperate::doesObjectExists( $arrTmpToken, $bRtn );
				if ( 0 == $nErrCode )
				{
					if ( ! $bRtn )
					{
						$this->echoTestResult( true, $sTestName );
					}
					else
					{
						$this->echoTestResult( false, $sTestName, '验证结果与预期不符' );
					}
				}
				else
				{
					$this->echoTestResult( false, $sTestName, '验证失败,错误码:' . $nErrCode );
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

