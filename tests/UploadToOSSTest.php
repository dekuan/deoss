<?php

require_once( __DIR__ . "/TestBase.php" );

define( 'UploadToOSSTestSkip', 1 );

class UploadToOSSTest extends TestBase
{

	public function testUploadToOSS ()
	{
		$this->skipTest( UploadToOSSTestSkip );
		$sTestName = '上传图片到OSS';
		$arrConfig = $this->getDefaultConfig();

		$arrTmpToken['AccessKeyId']     = $arrConfig['accesskeyid'];
		$arrTmpToken['AccessKeySecret'] = $arrConfig['accesskeysecret'];
		$arrTmpToken['bktinnerurl']     = $arrConfig['ossserverinternal'];
		$arrTmpToken['bkturl']          = $arrConfig['ossserver'];
		$arrTmpToken['useinner']        = \dekuan\deoss\CConst::CONST_NOT_USE_INNER;
		$arrTmpToken['bucket']          = 'deimage';
		$arrTmpToken['filename']        = 'test.jpg';
		$arrTmpToken['filepath']        = __DIR__ . '/../test.jpg';

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


	public function testUploadToOSSWithOneFile ()
	{
		$this->skipTest( UploadToOSSTestSkip & 0);
		$sTestName = '使用唯一source token上传非授权图片到OSS';
		$arrConfig = $this->getOneFileConfig();

		$arrToken = [];
		$nErrCode = \dekuan\deoss\CSTSOperate::getToken( '1234567890', $arrConfig, $arrToken );

		if ( 0 == $nErrCode )
		{
			if ( ( is_array( $arrToken ) && array_key_exists( 'Credentials', $arrToken ) ) )
			{
				$arrTmpToken                = $arrToken['Credentials'];
				$arrTmpToken['bktinnerurl'] = $arrConfig['ossserverinternal'];
				$arrTmpToken['bkturl']      = $arrConfig['ossserver'];
				$arrTmpToken['useinner']	= \dekuan\deoss\CConst::CONST_NOT_USE_INNER;
				$arrTmpToken['bucket']		= 'deimage';
				$arrTmpToken['filename']	= 'onlyonefile1.jpg';
				$arrTmpToken['filepath']	= __DIR__ . '/onlyonefile.jpeg';

				$nErrCode = \dekuan\deoss\COSSOperate::uploadToOSS( $arrTmpToken );
				if ( \dekuan\deoss\CErrCode::ERR_OSS_UPLOAD_EXCEPTION == $nErrCode )
				{
					$this->echoTestResult( true, $sTestName );
				}
				else
				{
					$this->echoTestResult( false, $sTestName, '上传至oss预期不符,错误码:' . $nErrCode );
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



	public function testUploadToOSSWithOneFileLegal ()
	{
		$this->skipTest( UploadToOSSTestSkip & 0);
		$sTestName = '使用唯一source token上传授权图片到OSS';
		$arrConfig = $this->getOneFileConfig();

		$arrToken = [];
		$nErrCode = \dekuan\deoss\CSTSOperate::getToken( '1234567890', $arrConfig, $arrToken );

		if ( 0 == $nErrCode )
		{
			if ( ( is_array( $arrToken ) && array_key_exists( 'Credentials', $arrToken ) ) )
			{
				$arrTmpToken                = $arrToken['Credentials'];
				$arrTmpToken['bktinnerurl'] = $arrConfig['ossserverinternal'];
				$arrTmpToken['bkturl']      = $arrConfig['ossserver'];
				$arrTmpToken['useinner']	= \dekuan\deoss\CConst::CONST_NOT_USE_INNER;
				$arrTmpToken['bucket']		= 'deimage';
				$arrTmpToken['filename']	= 'onlyonefile.jpg';
				$arrTmpToken['filepath']	= __DIR__ . '/onlyonefile.jpeg';

				$nErrCode = \dekuan\deoss\COSSOperate::uploadToOSS( $arrTmpToken );
				if ( \dekuan\deoss\CErrCode::ERR_SUCCESS == $nErrCode )
				{
					$this->echoTestResult( true, $sTestName );
				}
				else
				{
					$this->echoTestResult( false, $sTestName, '上传至oss预期不符,错误码:' . $nErrCode );
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


	public function testUploadToOSSWithDir ()
	{
		$this->skipTest( UploadToOSSTestSkip );
		$sTestName = '上传图片到OSS目录';
		$arrConfig = $this->getDefaultConfig();

		$arrTmpToken['AccessKeyId']     = $arrConfig['accesskeyid'];
		$arrTmpToken['AccessKeySecret'] = $arrConfig['accesskeysecret'];
		$arrTmpToken['bktinnerurl']     = $arrConfig['ossserverinternal'];
		$arrTmpToken['bkturl']          = $arrConfig['ossserver'];
		$arrTmpToken['useinner']        = \dekuan\deoss\CConst::CONST_NOT_USE_INNER;
		$arrTmpToken['bucket']          = 'deimage';
		$arrTmpToken['filename']        = 'user/test.jpg';
		$arrTmpToken['filepath']        = __DIR__ . '/../test.jpg';

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


	public function testUploadToOSSWithNoExt ()
	{
		$this->skipTest( UploadToOSSTestSkip );
		$sTestName = '上传图片到OSS';
		$arrConfig = $this->getDefaultConfig();

		$arrTmpToken['AccessKeyId']     = $arrConfig['accesskeyid'];
		$arrTmpToken['AccessKeySecret'] = $arrConfig['accesskeysecret'];
		$arrTmpToken['bktinnerurl']     = $arrConfig['ossserverinternal'];
		$arrTmpToken['bkturl']          = $arrConfig['ossserver'];
		$arrTmpToken['useinner']        = \dekuan\deoss\CConst::CONST_NOT_USE_INNER;
		$arrTmpToken['bucket']          = 'deimage';
		$arrTmpToken['filename']        = '15191418717';
		$arrTmpToken['filepath']        = __DIR__ . '/../15191418717';

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


	public function testUploadToOSSWithToken ()
	{
		$this->skipTest( UploadToOSSTestSkip );
		$sTestName = '使用token上传图片到OSS';
		$arrConfig = $this->getDefaultConfig();

		$arrToken = [ ];
		$nErrCode = \dekuan\deoss\CSTSOperate::getToken( '1234567890', $arrConfig, $arrToken );

		if ( 0 == $nErrCode )
		{
			if ( ( is_array( $arrToken ) && array_key_exists( 'Credentials', $arrToken ) ) )
			{
				$arrTmpToken                = $arrToken['Credentials'];
				$arrTmpToken['bktinnerurl'] = $arrConfig['ossserverinternal'];
				$arrTmpToken['bkturl']      = $arrConfig['ossserver'];
				$arrTmpToken['useinner']    = \dekuan\deoss\CConst::CONST_NOT_USE_INNER;
				$arrTmpToken['bucket']      = 'deimage';
				$arrTmpToken['filename']    = 'test1.jpg';
				$arrTmpToken['filepath']    = __DIR__ . '/../test.jpg';

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


	public function testUploadToOSSWithReadToken ()
	{
		$this->skipTest( UploadToOSSTestSkip );
		$sTestName = '使用token上传图片到OSS';
		$arrConfig = $this->getReadConfig();

		$arrToken = [ ];
		$nErrCode = \dekuan\deoss\CSTSOperate::getToken( '1234567890', $arrConfig, $arrToken );

		if ( 0 == $nErrCode )
		{
			if ( ( is_array( $arrToken ) && array_key_exists( 'Credentials', $arrToken ) ) )
			{
				$arrTmpToken                = $arrToken['Credentials'];
				$arrTmpToken['bktinnerurl'] = $arrConfig['ossserverinternal'];
				$arrTmpToken['bkturl']      = $arrConfig['ossserver'];
				$arrTmpToken['useinner']    = \dekuan\deoss\CConst::CONST_NOT_USE_INNER;
				$arrTmpToken['bucket']      = 'deimage';
				$arrTmpToken['filename']    = 'test1.jpg';
				$arrTmpToken['filepath']    = __DIR__ . '/../test.jpg';

				$nErrCode = \dekuan\deoss\COSSOperate::uploadToOSS( $arrTmpToken );
				if ( \dekuan\deoss\CErrCode::ERR_OSS_UPLOAD_EXCEPTION == $nErrCode )
				{
					$this->echoTestResult( true, $sTestName );
				}
				else
				{
					$this->echoTestResult( false, $sTestName, '上传至oss预期不符,错误码:' . $nErrCode );
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