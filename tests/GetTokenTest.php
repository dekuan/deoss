<?php 

require_once( __DIR__ . "/TestBase.php" );

define( 'GetTokenTestSkip', 1 );

class GetTokenTest extends TestBase {
	public function testGetToken()
	{
		$this->skipTest( GetTokenTestSkip );
		$sTestName = '获取Token';

		$arrConfig = $this->getDefaultConfig();

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
}
