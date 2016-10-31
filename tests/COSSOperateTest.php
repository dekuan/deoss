<?php

require ( __DIR__ . '/../src/COSSOperate.php' );
require ( __DIR__ . '/../src/CSTSOperate.php' );
require ( __DIR__ . '/../src/CConst.php' );
require ( __DIR__ . '/../src/CErrCode.php' );
class COSSOperateTest extends \PHPUnit_Framework_TestCase
{
	public function testUploadToOSS()
	{
		$arrConfig = $this->_getDefaultConfig();

		$arrToken = [];
		$nErrCode = \dekuan\deoss\CSTSOperate::getToken( 'wan-test-1', $arrConfig, $arrToken );
		$this->assertEquals( 0, $nErrCode );
		print_r( $arrToken );
	}


	private function _getDefaultConfig()
	{
		$arrConfig = [
			'accesskeyid' => 'LTAIAV4YnHFslQLX',
			'accesskeysecret' => 'X39ahW2PieiOlVg47OMxu1kT5srjcT',
			'bucket' => 'deimage',
			'ossserverinternal' => 'deimage.oss-cn-beijing-internal.aliyuncs.com',
			'ossserver' => 'deimage.oss-cn-beijing.aliyuncs.com',
			'stsserver' => 'cn-hangzhou',
			'sonaccesskeyid' => 'LTAIAV4YnHFslQLX',
			'sonaccesskeysecret' => 'X39ahW2PieiOlVg47OMxu1kT5srjcT',
			'rolearn' => 'acs:ram::1221465791569748:role/img-writer',
			'tokeneffectivetime' => 1200
		];

		return $arrConfig;
	}
}
