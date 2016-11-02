<?php

require_once ( __DIR__ . '/../src/COSSOperate.php' );
require_once ( __DIR__ . '/../src/CSTSOperate.php' );
require_once ( __DIR__ . '/../src/CConst.php' );
require_once ( __DIR__ . '/../src/CErrCode.php' );


class TestBase extends \PHPUnit_Framework_TestCase {
	public function getDefaultConfig()
	{
		$arrConfig = [
			'accesskeyid' => 'LTAIAV4YnHFslQLX',
			'accesskeysecret' => 'X39ahW2PieiOlVg47OMxu1kT5srjcT',
			'bucket' => 'deimage',
			'ossserverinternal' => 'oss-cn-beijing-internal.aliyuncs.com',
			'ossserver' => 'oss-cn-beijing.aliyuncs.com',
			'stsserver' => 'cn-hangzhou',
			'rolearn' => 'acs:ram::1221465791569748:role/img-writer',
			'tokeneffectivetime' => 1200,
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
			'imgurl' => 'http://deimage.dekuan.org'
		];

		return $arrConfig;
	}



	public function getReadConfig()
	{
		$arrConfig = [
			'accesskeyid' => 'LTAIAV4YnHFslQLX',
			'accesskeysecret' => 'X39ahW2PieiOlVg47OMxu1kT5srjcT',
			'bucket' => 'deimage',
			'ossserverinternal' => 'oss-cn-beijing-internal.aliyuncs.com',
			'ossserver' => 'oss-cn-beijing.aliyuncs.com',
			'stsserver' => 'cn-hangzhou',
			'rolearn' => 'acs:ram::1221465791569748:role/img-writer',
			'tokeneffectivetime' => 1200,
			'policy' => <<<EOF
				{
					"Version": "1",
					"Statement":
					[{
						"Effect": "Allow",
						"Action": ["oss:List*", "oss:Get*"],
						"Resource": ["acs:oss:*:*:deimage", "acs:oss:*:*:deimage/*"]
					}]
				}
EOF
			,
			'imgurl' => 'http://deimage.dekuan.org'
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

