<?php
App::import('Vendor', 'CFRuntime', null, null, 'AWSSDKforPHP/sdk.class.php')
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
App::uses('CakeDocument', 'MongoCake.Model');

/** @ODM\Document */
class AmazonServer extends CakeDocument {

/**
 * Server Id
 *
 * @ODM\Id
 * @var string
 */
	private $id;

/**
 * Amazon assigned instance ID
 *
 * @ODM\String
 * @var string
 */
	public $instanceId;

/**
 * Public IP Address (DNS)
 *
 * @ODM\String
 * @var string
 */
	public $ipAddress;

/**
 * Creation date and time
 *
 * @ODM\Date
 * @var DateTime
 */
	public $created;

/**
 * Modified date and time
 *
 * @ODM\Date
 * @var DateTime
 */
	public $modified;

/**
 * Pause the instance (Only works for EBS backed instances)
 *
 * @return boolean True if the operation was a success
 */
	public function stop() {
		if (!$this->instanceId) {
			throw new EC2_Exception('AmazonServer has no instance Id');
		}
		$ec2 = new AmazonEc2();
		$response = $ec2->stop_instances($this->instanceId);
		return $this->_amazonResponseOK($response);
	}

/**
 * Determine if the response from Amazon was "Ok"
 *
 * @param CFResponse $response Response object
 * @return boolean True if success
 */
	protected function _amazonResponseOk(CFResponse $response) {
		return $response->isOK();
	}
}