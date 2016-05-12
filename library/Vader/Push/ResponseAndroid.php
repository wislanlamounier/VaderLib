<?php
class Vader_Push_ResponseAndroid
{
  public $multicast_id;
  public $success;
  public $failure;
  public $canonical_ids;
  public $results;
  public $message_id;
  public $error;
  
  public function __construct()
  {
    return $this;
  }
  
  public function setRespostas($json)
  {
    $obj = json_decode($json);
    $array = (array)$obj;
    $this->setMulticast_id($array['multicast_id']);
    $this->setSuccess($array['success']);
    $this->setFailure($array['failure']);
    $this->setCanonical_ids($array['canonical_ids']);
    $this->setMessage_id($array['results'][0]->message_id);
    $this->setError($array['results'][0]->error);
    return $this;
  }
          
  function getMulticast_id()
  {
    return $this->multicast_id;
  }

  function getSuccess()
  {
    return $this->success;
  }

  function getFailure()
  {
    return $this->failure;
  }

  function getCanonical_ids()
  {
    return $this->canonical_ids;
  }

  function getResults()
  {
    return $this->results;
  }

  function getMessage_id()
  {
    return $this->message_id;
  }

  function setMulticast_id($multicast_id)
  {
    $this->multicast_id = $multicast_id;
    return $this;
  }

  function setSuccess($success)
  {
    $this->success = $success;
    return $this;
  }

  function setFailure($failure)
  {
    $this->failure = $failure;
    return $this;
  }

  function setCanonical_ids($canonical_ids)
  {
    $this->canonical_ids = $canonical_ids;
    return $this;
  }

  function setResults($results)
  {
    $this->results = $results;
    return $this;
  }

  function setMessage_id($message_id)
  {
    $this->message_id = $message_id;
    return $this;
  }
  
  function getError()
  {
    return $this->error;
  }

  function setError($error)
  {
    $this->error = $error;
  }
}