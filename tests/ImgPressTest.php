<?php

require_once (__DIR__ . "/TestBase.php" );

define( 'ImgPressTestSkip', 1 );
class ImgPressTest extends TestBase
{
	public function testImgPress()
	{
		$this->skipTest( ImgPressTestSkip );
		$sTestName = '获得图片请求url';
		$arrConfig = $this->getDefaultConfig();

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


	public function testImgPressWithDir()
	{
		$this->skipTest( ImgPressTestSkip & 0 );
		$sTestName = '获得oss文件夹中的图片请求url';
		$arrConfig = $this->getDefaultConfig();

		$arrTmpToken[ 'AccessKeyId' ] = $arrConfig[ 'accesskeyid' ];
		$arrTmpToken[ 'AccessKeySecret' ] = $arrConfig[ 'accesskeysecret' ];
		$arrTmpToken[ 'useinner' ] = \dekuan\deoss\CConst::CONST_NOT_USE_INNER;
		$arrTmpToken[ 'bucket' ] = 'deimage';
		$arrTmpToken[ 'imgurl' ] = $arrConfig[ 'imgurl' ];
		$arrTmpToken[ 'filename' ] = 'user/test.jpg';		//	存在

		$sRtn = null;
		$nErrCode = \dekuan\deoss\COSSOperate::imgProcess( $arrTmpToken, $sRtn );
		if ( 0 == $nErrCode )
		{
			if ( is_string( $sRtn ) && strlen( $sRtn ) > 0 )
			{
				echo $sRtn . "\n";
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



}
