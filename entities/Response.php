<?php
/*
 * PHP Class that holds two parameters that will be sent along with the Response Object
 */
class Response implements \JsonSerializable {
  private $responseFlag;
  private $responseMessage;

  /**
   * @return mixed
   */
  public function getResponseMessage() {
    return $this->responseMessage;
  }

  /**
   * @param mixed $responseMessage
   */
  public function setResponseMessage($responseMessage) {
    $this->responseMessage = $responseMessage;
  }

  /**
   * @return mixed
   */
  public function getResponseFlag() {
    return $this->responseFlag;
  }

  /**
   * @param mixed $responseFlag
   */
  public function setResponseFlag($responseFlag) {
    $this->responseFlag = $responseFlag;
  }

  /**
   * (PHP 5 &gt;= 5.4.0)<br/>
   * Specify data which should be serialized to JSON
   * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
   * @return mixed data which can be serialized by <b>json_encode</b>,
   * which is a value of any type other than a resource.
   */
  function jsonSerialize() {
    $vars = get_object_vars($this);
    return $vars;
  }
}

?>