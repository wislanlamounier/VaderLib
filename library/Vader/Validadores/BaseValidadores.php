<?php
class Vader_Validadores_BaseValidadores
{
  protected $length;
  protected $validado = false;
  protected $whiteList;
  

    public function validaCpf($cpf = false)
  {
    $this->length = strlen($cpf);
    
    // Verifica se um número foi informado
    if(empty($cpf))
    {
      $this->validado = false;
      return false;
    }

    // Elimina possivel mascara
    $cpf = ereg_replace('[^0-9]', '', $cpf);
    $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

    // Verifica se o numero de digitos informados é igual a 11 
    if(strlen($cpf) != 11)
    {
      $this->validado = false;
      return false;
    }
    // Verifica se nenhuma das sequências invalidas abaixo 
    // foi digitada. Caso afirmativo, retorna falso
    else if($cpf == '00000000000' ||
            $cpf == '11111111111' ||
            $cpf == '22222222222' ||
            $cpf == '33333333333' ||
            $cpf == '44444444444' ||
            $cpf == '55555555555' ||
            $cpf == '66666666666' ||
            $cpf == '77777777777' ||
            $cpf == '88888888888' ||
            $cpf == '99999999999')
    {
      $this->validado = false;
      return false;
      // Calcula os digitos verificadores para verificar se o
      // CPF é válido
    }
    else
    {

      for($t = 9; $t < 11; $t++)
      {

        for($d = 0, $c = 0; $c < $t; $c++)
        {
          $d += $cpf{$c} * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if($cpf{$c} != $d)
        {
          $this->validado = false;
          return false;
        }
      }

      $this->validado = true;
      return true;
    }
  }
  
  public function ValidaEmail($email)
  {
    $this->length = strlen($email);
    if(substr_count($email, "@") <= 0 || strlen($email) == 0)
    {
      $this->validado = false;
      return false;
    }
    else
    {
      $this->validado = true;
      return true;
    }
  }
  
  public function ValidaSenha($senha)
  {
    $length = strlen($senha);
    
    if($length < 6)
      return false;
    else
      return true;
  }
  
  public function validarBancoDeDados($tabela, $obj)
  {
    $parans = (array)$obj;
    $keyArray = array_keys($parans);
    
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();

    $sql = 'Desc '.$tabela;
    $result = $db->fetchAll($sql);
    foreach($result as $chave => $valor)
    {
      if(!array_search($valor->Field , $this->whiteList, false))
      {
        $nomeCampo = $valor->Field;
        $type = $this->removerCaracteres($valor->Type);
        $chaveArray = array_search($nomeCampo , $keyArray, false);
        if($chaveArray || $chaveArray === 0)
        {
          $KeyVerificar = $keyArray[$chaveArray];
          $valorCampo = $parans[$KeyVerificar];
          
          if($valor->Null == "NO" || (empty($valor->Default) && $valor->Default !== null))
          {
            if(empty($valorCampo) && $valorCampo != 0 || $valorCampo === null)
              throw new Exception ('O campo '. $KeyVerificar. ' Não está preenchido corretamente');
          }

          if($type == "int")
          {
            if(!is_numeric($valorCampo))
              throw new Exception ('O campo '. $KeyVerificar. ' Não é numero');
          }
          if($this->length > 0)
          {
            if(strlen($valorCampo) > $this->length && $type != 'char')
              throw new Exception ('O campo '. $KeyVerificar. ' está muito grande');

            else if (strlen($valorCampo) != $this->length && $type == 'char')
              throw new Exception ('O campo '. $KeyVerificar. ' este campo necessida ter exatamente '.$this->length.' caracteres ');
          }
          if($nomeCampo == 'CPF' || $nomeCampo == 'cpf')
          {
            if(!$this->validaCpf($valorCampo))
              throw new Exception ('O campo '. $KeyVerificar. ' tem um CPF que não é válido');
          }
          if($nomeCampo == 'Email' || $nomeCampo == 'EmailUsuario')
          {
            if(!$this->ValidaEmail($valorCampo))
              throw new Exception ('Email que não é válido');
          }
        }
        else
        {
          if($valor->Key != "PRI")
          {
            if($valor->Null == "NO" && $valor->Default == null)
            {
              if($valor->Extra != 'auto_increment')
              {
                throw new Exception ('O campo '.$valor->Field.' não pode ser vazio');
              }
            }
          }
        }
        
      }
    }
  }
  
  private function removerCaracteres($string)
  {
    $tamanho = preg_replace("/[^0-9]/", "", $string);
    $retorno = split("\(".$tamanho.")", $string);
    $this->length = $tamanho;
    return $retorno[0];
  }
  
  function getLength()
  {
    return $this->length;
  }

  function getValidado()
  {
    return $this->validado;
  }

  function getWhiteList()
  {
    return $this->whiteList;
  }

  function setLength($length)
  {
    $this->length = $length;
  }

  function setValidado($validado)
  {
    $this->validado = $validado;
  }

  function setWhiteList($whiteList)
  {
    $this->whiteList = $whiteList;
  }
}
