<?php
namespace dekuan\deoss;

//use OSS\AssumeRoleRequest;
//use \Sts\Request\V20150401 as Sts;
use OSS\OssClient;


class COSSOperate
{
	protected $client               =   "";
	protected $accessKeyId          =   "";
	protected $accessKeySecret      =   "";
	protected $endPoint             =   "";
	protected $bucket               =   "";
	protected $stsServer            =   "";
	protected $sonAccessKeyId       =   "";
	protected $sonAccessKeySecret   =   "";
	protected $roleArn              =   "";
	protected $tokeneffectivetime   =   "";

	private   $ossServer            = 'http://oss-cn-beijing.aliyuncs.com';
	private   $ossServerInternal    = 'http://oss-cn-beijing-internal.aliyuncs.com';
	private   $imgServer            = 'http://img-cn-beijing.aliyuncs.com';

	protected static $instance;


	private function __clone(){}

	public function __construct( $arrConfig )
	{
		$this->_Init( $arrConfig );
	}

	public static function getInstance( $arrConfig )
	{
		if ( null == self::$instance || ! isset( self::$instance ) || ! self::$instance instanceof self )
		{
			self::$instance = new self( $arrConfig );
		}
		return self::$instance;
	}

	public function uploadToOSS( $sObject, $sFile , $Bucket = NULL )
	{
		$Bucket = is_null($Bucket) ? self::$instance->bucket : $Bucket;
		return self::$instance->client->uploadFile( $Bucket , $sObject , $sFile );
	}

	public function doesObjectExists($sOssKey,$Bucket = NULL)
	{
		$Bucket = is_null($Bucket) ? self::$instance->bucket : $Bucket;
		return self::$instance->client->doesObjectExist($Bucket,$sOssKey);
	}

	public function getObject($sOssKey,$Options = NULL ,$Bucket = NULL)
	{
		$Bucket = is_null($Bucket) ? self::$instance->bucket : $Bucket;
		return self::$instance->client->getObject($Bucket,$sOssKey,$Options);
	}


	public function PutToOSS( $sObject,$Content , $Options = NULL,$Bucket = NULL )
	{
		$Bucket = is_null($Bucket) ? self::$instance->bucket : $Bucket;
		return self::$instance->Client->putObject( $Bucket , $sObject , $Content, $Options );
	}

	public function deleteObjectFromOSS( $sOssKey ,$Options = NULL ,$Bucket = NULL)
	{
		$Bucket = is_null($Bucket) ? self::$instance->bucket : $Bucket;
		return self::$instance->Client->deleteObject( $Bucket , $sOssKey , $Options );
	}

	public function deleteObjectsFromOSS( $arrOssKeys ,$Options = NULL ,$Bucket = NULL)
	{
		$Bucket = is_null($Bucket) ? self::$instance->bucket : $Bucket;
		return self::$instance->Client->deleteObjects( $Bucket , $arrOssKeys , $Options );
	}



	public function ImgProcess( $sOssKey , $nTimeout = 60 , $Bucket = NULL)
	{
		$Bucket = is_null($Bucket) ? self::$instance->bucket : $Bucket;
		self::$instance->endPoint = $this->imgServer;
		self::$instance->client = new OssClient(self::$instance->accessKeyId,self::$instance->accessKeySecret,self::$instance->endPoint);
		$processResult = self::$instance->client->signUrl($Bucket , $sOssKey , $nTimeout);
		self::$instance->endPoint = $this->_isInner()? $this->ossServerInternal : $this->ossServer;
		$this->client = new OssClient(self::$instance->accessKeyId, self::$instance->accessKeySecret,self::$instance->endPoint);
		return $processResult;
	}


	//public function receiveFileToLocal( $sFilePath = "" , $vStreamData = "")
	//{
	//	require dirname(__FILE__)."/UploadImg.php";
	//	$cUpf	= new CLQQFileUploader();
	//	$nUpResult = $cUpf->saveUploadFile( $sFilePath );
	//	if(0 == $nUpResult)
	//	{
	//		return $sFilePath;
	//	}
	//	else
	//	{
	//		return $nUpResult;
	//	}
	//}

	public function getUrl($sOssKey , $nTimeout = 60 , $Bucket = NULL)
	{
		$Bucket = is_null($Bucket) ? self::$instance->bucket : $Bucket;
		$options = [
			'ResponseContentType' => 'image/jpeg',
			'ResponseContentDisposition' => 'image/jpeg'
		];
		//$myClient->EndPoint = \Config::get('app.imgServer');
		//$myClient->Client = new OssClient($myClient->AccessKeyId,$myClient->AccessKeySecret,$myClient->EndPoint);
		return self::$instance->client->signUrl($Bucket , $sOssKey , $nTimeout,'GET', $options);
	}


	////////////////////////////////////////////////////////////////////////////////
	//  Private
	//

	/**
	 * 对象初始化类
	 *
	 * @author wanganning
	 * @modify-log
	 *        name            date            reason
	 *        王安宁
	 *
	 * @param $arrConfig
	 */
	private function _Init( $arrConfig )
	{
		//初始化OSS，生成oss对象
		//include_once dirname(__FILE__).'/Config.php';
		if(is_array( $arrConfig ) && count( $arrConfig ) > 0 )
		{
			//dd($aliyunConfig);
			$this->accessKeyId          =   array_key_exists( 'accesskeyid', $arrConfig ) ? $arrConfig['accesskeyid'] : null;
			$this->accessKeySecret      =   array_key_exists( 'accesskeysecret', $arrConfig ) ? $arrConfig[ 'accesskeysecret' ] : null;
			$this->bucket               =   array_key_exists( 'bucket', $arrConfig ) ? $arrConfig['bucket'] : null;
			$this->ossServerInternal	=	array_key_exists( 'ossserverinternal', $arrConfig ) ? $arrConfig[ 'ossserverinternal' ] : null;
			$this->ossServer			=	array_key_exists( 'ossserver', $arrConfig ) ? $arrConfig[ 'ossserver' ] : null;
			$this->endPoint             =   $this->_isInner() ? $this->ossServerInternal : $this->ossServer;
			$this->stsServer            =   array_key_exists( 'stsserver', $arrConfig ) ? $arrConfig[ 'e' ] : null;
			$this->sonAccessKeyId       =   array_key_exists( 'sonaccesskeyid', $arrConfig ) ? $arrConfig[ 'sonaccesskeyid' ] : null;
			$this->sonAccessKeySecret   =   array_key_exists( 'sonaccesskeysecret', $arrConfig ) ? $arrConfig[ 'sonaccesskeysecret' ] : null;
			// 角色资源描述符，在RAM的控制台的资源详情页上可以获取
			$this->roleArn              =   array_key_exists( 'writerolearn', $arrConfig ) ? $arrConfig[ 'writerolearn' ] : null;
			$this->tokeneffectivetime   =   array_key_exists( 'tokeneffectivetime', $arrConfig ) ? $arrConfig[ 'tokeneffectivetime' ] : null;
			$this->client               =   new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endPoint);
			$this->client->setTimeout(5);
			$this->client->setConnectTimeout(20);
		}
	}

	//检查是否是内网
	private function _isInner()
	{
		return false;
	}
}