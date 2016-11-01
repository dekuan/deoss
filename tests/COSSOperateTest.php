<?php

require ( __DIR__ . '/../src/COSSOperate.php' );
require ( __DIR__ . '/../src/CSTSOperate.php' );
require ( __DIR__ . '/../src/CConst.php' );
require ( __DIR__ . '/../src/CErrCode.php' );

define( 'OSSTestSkip', 1 );
class COSSOperateTest extends \PHPUnit_Framework_TestCase
{
	public function testGetToken()
	{
		$this->skipTest( OSSTestSkip );
		$sTestName = '获取Token';

		$arrConfig = $this->_getDefaultConfig();

		$arrToken = [];
		$nErrCode = \dekuan\deoss\CSTSOperate::getToken( '1234567890', $arrConfig, $arrToken );

		if ( 0 == $nErrCode )
		{
			if ( is_array( $arrToken ) && array_key_exists( 'Credentials', $arrToken ) )
			{
				$this->echoTestResult( true, $sTestName );
			}
			else
			{
				$this->echoTestResult( false, $sTestName, '返回token验证失败' );
			}
		}
		else
		{
			$this->echoTestResult( false, $sTestName, '获的token失败,错误码:' . $nErrCode );
		}
	}

	public function testUploadToOSS()
	{
		$this->skipTest( OSSTestSkip );
		$sTestName = '上传图片到OSS';
		$arrConfig = $this->_getDefaultConfig();

		$arrTmpToken[ 'AccessKeyId' ] = $arrConfig[ 'accesskeyid' ];
		$arrTmpToken[ 'AccessKeySecret' ] = $arrConfig[ 'accesskeysecret' ];
		$arrTmpToken[ 'bktinnerurl' ] = $arrConfig[ 'ossserverinternal' ];
		$arrTmpToken[ 'bkturl' ] = $arrConfig[ 'ossserver' ];
		$arrTmpToken[ 'useinner' ] = \dekuan\deoss\CConst::CONST_NOT_USE_INNER;
		$arrTmpToken[ 'bucket' ] = 'deimage';
		$arrTmpToken[ 'filename' ] = 'test.jpg';
		$arrTmpToken[ 'filepath' ] = __DIR__ . '/../test.jpg';

		$nErrCode = \dekuan\deoss\COSSOperate::uploadToOSS( $arrTmpToken );
		if ( 0 == $nErrCode )
		{
			$this->echoTestResult( true, $sTestName );
		}
		else
		{
			$this->echoTestResult( false, $sTestName, '上传至oss失败,错误码:' . $nErrCode );
		}
	}


	public function testUploadToOSSWithToken()
	{
		$this->skipTest( OSSTestSkip );
		$sTestName = '使用token上传图片到OSS';
		$arrConfig = $this->_getDefaultConfig();

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
				$arrTmpToken[ 'filename' ] = 'test1.jpg';
				$arrTmpToken[ 'filepath' ] = __DIR__ . '/../test.jpg';

				$nErrCode = \dekuan\deoss\COSSOperate::uploadToOSS( $arrTmpToken );
				if ( 0 == $nErrCode )
				{
					$this->echoTestResult( true, $sTestName );
				}
				else
				{
					$this->echoTestResult( false, $sTestName, '上传至oss失败,错误码:' . $nErrCode );
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

	public function testDoesObjectExists()
	{
		$this->skipTest( OSSTestSkip );
		$sTestName = '验证object在oss是否存在';
		$arrConfig = $this->_getDefaultConfig();

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
	}

	public function testDoesObjectExistsWithToken()
	{
		$this->skipTest( OSSTestSkip );
		$sTestName = '使用token验证object在oss是否存在';

		$arrConfig = $this->_getDefaultConfig();

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


	public function testGetObject()
	{
		$this->skipTest( OSSTestSkip );
		$sTestName = '从oss上获得对象信息';
		$arrConfig = $this->_getDefaultConfig();

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
	}


	public function testGetObjectWithToken()
	{
		$this->skipTest( OSSTestSkip );
		$sTestName = '使用token从oss上获得对象信息';
		$arrConfig = $this->_getDefaultConfig();

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

	public function testImgPress()
	{
		$this->skipTest( OSSTestSkip );
		$sTestName = '获得图片请求url';
		$arrConfig = $this->_getDefaultConfig();

		$arrTmpToken[ 'AccessKeyId' ] = $arrConfig[ 'accesskeyid' ];
		$arrTmpToken[ 'AccessKeySecret' ] = $arrConfig[ 'accesskeysecret' ];
		$arrTmpToken[ 'useinner' ] = \dekuan\deoss\CConst::CONST_NOT_USE_INNER;
		$arrTmpToken[ 'bucket' ] = 'deimage';
		$arrTmpToken[ 'imgurl' ] = $arrConfig[ 'imgurl' ];
		$arrTmpToken[ 'filename' ] = 'test.jpg';		//	存在

		$sRtn = null;
		$nErrCode = \dekuan\deoss\COSSOperate::imgProcess( $arrTmpToken, $sRtn );
		if ( 0 == $nErrCode )
		{
			if ( is_string( $sRtn ) && strlen( $sRtn ) > 0 )
			{
				$this->echoTestResult( true, $sTestName );
			}
			else
			{
				$this->echoTestResult( false, $sTestName, '获得图片访问地址,返回值验证错误' );
			}
		}
		else
		{
			$this->echoTestResult( false, $sTestName, '获得图片访问地址失败,错误码:' . $nErrCode );
		}


		$arrTmpToken[ 'filename' ] = 'test2.jpg';		//	不存在

		$sRtn = null;
		$nErrCode = \dekuan\deoss\COSSOperate::imgProcess( $arrTmpToken, $sRtn );
		if ( 0 == $nErrCode )
		{
			if ( is_string( $sRtn ) && strlen( $sRtn ) > 0 )
			{
				$this->echoTestResult( true, $sTestName );
			}
			else
			{
				$this->echoTestResult( false, $sTestName, '获得图片访问地址,返回值验证错误' );
			}
		}
		else
		{
			$this->echoTestResult( false, $sTestName, '获得图片访问地址失败,错误码:' . $nErrCode );
		}
	}


	private function _getDefaultConfig()
	{
		$arrConfig = [
			'accesskeyid' => '',
			'accesskeysecret' => '',
			'bucket' => '',
			'ossserverinternal' => '',
			'ossserver' => '',
			'stsserver' => '',
			'rolearn' => '',
			'tokeneffectivetime' => '',
			'policy' => <<<EOF
				{
  					"Statement": [
    				{
      					"Action": "oss:*",
      					"Effect": "Allow",
      					"Resource": "*"
					}
				  ],
				  "Version": "1"
				}
EOF
			,
			'imgurl' => ''
		];

		return $arrConfig;
	}


	public function mySeeJson ( $arrBaseArr, $arrFindArr )
	{
		if ( ! is_array( $arrBaseArr ) || count( $arrBaseArr ) <= 0 )
		{
			return false;
		}

		if ( ! is_array( $arrFindArr ) || count( $arrFindArr ) <= 0 )
		{
			return false;
		}

		$bRtn = false;

		foreach ( $arrFindArr as $key => $value )
		{
			$bRtn = false;
			if ( array_key_exists( $key, $arrBaseArr ) )
			{
				if ( is_array( $value ) )
				{
					if ( is_array( $arrBaseArr[ $key ] ) )
					{
						if ( count( $value ) > 0 && count( $arrBaseArr[ $key ] ) > 0 )
						{
							$bRtn = $this->mySeeJson( $arrBaseArr[ $key ], $value );
						}
						else if ( count( $value ) == 0 && count( $arrBaseArr[ $key ] ) == 0 )
						{
							$bRtn = true;
						}
					}
				}
				else
				{
					if ( $value === $arrBaseArr[ $key ] )
					{
						$bRtn = true;
					}
				}
			}

			if ( ! $bRtn )
			{
				break;
			}
		}

		return $bRtn;
	}

	public function echoTestResult( $bIsSucc, $sContent, $sExtend = null )
	{
		$sMessage = "\n" . '[' . date( 'Ymd H:i:s' ) . ']';

		if ( $bIsSucc )
		{
			$sMessage .= '[INFO]';
		}
		else
		{
			$sMessage .= '[ERR]';
		}

		if ( is_string( $sContent ) )
		{
			if ( $bIsSucc )
				$sMessage .= $sContent . '测试通过' ;
			else
				$sMessage .= $sContent . '测试未通过';

			if ( is_string( $sExtend ) && ! $bIsSucc )
			{
				$sMessage .= "; 原因: " . $sExtend;
			}
		}

		$sMessage .= "\n";

		echo $sMessage;

		if ( $bIsSucc )
		{
			$this->assertTrue( true );
		}
		else
		{
			$this->assertTrue( false );
		}
	}

	public function skipTest( $nSkip )
	{
		if ( 1 == $nSkip )
		{
			$this->markTestSkipped();
		}
	}
}
