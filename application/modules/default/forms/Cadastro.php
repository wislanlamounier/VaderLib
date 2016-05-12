<?php
class Default_Form_Cadastro extends Zend_Validate
{
///==============================================================================================================
//Validadores
//==============================================================================================================
  
  function validaCPF($cpf = null)
  {

    // Verifica se um número foi informado
    if(empty($cpf))
    {
      return false;
    }

    // Elimina possivel mascara
    $cpf = ereg_replace('[^0-9]', '', $cpf);
    $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

    // Verifica se o numero de digitos informados é igual a 11 
    if(strlen($cpf) != 11)
    {
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
          return false;
        }
      }

      return true;
    }
  }

  public function ValidaCnpj($cnpj)
  {
    $j = 0;
    for($i = 0; $i < (strlen($cnpj)); $i++)
    {
      if(is_numeric($cnpj[$i]))
      {
        $num[$j] = $cnpj[$i];
        $j++;
      }
    }
    if(count($num) != 14)
    {
      $isCnpjValid = false;
    }
    if($num[0] == 0 && $num[1] == 0 && $num[2] == 0 && $num[3] == 0 && $num[4] == 0 && $num[5] == 0 && $num[6] == 0 && $num[7] == 0 && $num[8] == 0 && $num[9] == 0 && $num[10] == 0 && $num[11] == 0)
    {
      $isCnpjValid = false;
    }
    else
    {
      $j = 5;
      for($i = 0; $i < 4; $i++)
      {
        $multiplica[$i] = $num[$i] * $j;
        $j--;
      }
      $soma = array_sum($multiplica);
      $j = 9;
      for($i = 4; $i < 12; $i++)
      {
        $multiplica[$i] = $num[$i] * $j;
        $j--;
      }
      $soma = array_sum($multiplica);
      $resto = $soma % 11;
      if($resto < 2)
      {
        $dg = 0;
      }
      else
      {
        $dg = 11 - $resto;
      }
      if($dg != $num[12])
      {
        $isCnpjValid = false;
      }
    }
    if(!isset($isCnpjValid))
    {
      $j = 6;
      for($i = 0; $i < 5; $i++)
      {
        $multiplica[$i] = $num[$i] * $j;
        $j--;
      }
      $soma = array_sum($multiplica);
      $j = 9;
      for($i = 5; $i < 13; $i++)
      {
        $multiplica[$i] = $num[$i] * $j;
        $j--;
      }
      $soma = array_sum($multiplica);
      $resto = $soma % 11;
      if($resto < 2)
      {
        $dg = 0;
      }
      else
      {
        $dg = 11 - $resto;
      }
      if($dg != $num[13])
      {
        $isCnpjValid = false;
      }
      else
      {
        $isCnpjValid = true;
      }
    }
    return $isCnpjValid;
  }
  public function Validarpreenchido(array $parans)
  {
    $resposta = 0;
    foreach($parans as $validacoes)
    {
      if(empty($validacoes))
      {
        $resposta += 1;
      }
      if($validacoes == null)
      {
        $resposta +=1;
      }
    }
    if($resposta == 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  public function ValidaEmail($email)
  {
    if(substr_count($email, "@") < 0 || strlen($email) == 0)
    {
      return false;
    }
    else
    {
      return true;
    }
  }
  
  public function ValidaEmailParaCadastro($email)
  {
    if(substr_count($email, "@") < 0 || strlen($email) == 0)
    {
      return false;
    }
    else
    {
      try 
      {
        $obj = new Application_Model_DbTable_usuario();
        if($obj->GetUsuarioBYEmail($email))
        {
            return false;
        }
        else
        {
            return true;
        }
      }
      catch (Exception $e)
      {
          throw new Exception($e);
      }
     }
  }

  public function validasenha($senha)
  {
    if(strlen($senha) < 6)
    {
      return false;
    }
    else
    {
      return true;
    }
  }
  public function VerificarArquivo($arquivo)
  {
    if($arquivo['arquivo']['size'] == 0)
    {
      return false;
    }
    else
    {
      return true;
    }
  }
  public function CamposIguais($Campo, $CampoComparado)
  {
    if($Campo == $CampoComparado)
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  
  public function ReplaceDinheiro($dinheiro)
  {
    $str = $dinheiro; 
    $map = array(
        'á' => 'a',
        'à' => 'a',
        'ã' => 'a',
        'â' => 'a',
        'é' => 'e',
        'ê' => 'e',
        'í' => 'i',
        'ó' => 'o',
        'ô' => 'o',
        'õ' => 'o',
        'ú' => 'u',
        'ü' => 'u',
        'ç' => 'c',
        'Á' => 'A',
        'À' => 'A',
        'Ã' => 'A',
        'Â' => 'A',
        'É' => 'E',
        'Ê' => 'E',
        'Í' => 'I',
        'Ó' => 'O',
        'Ô' => 'O',
        'Õ' => 'O',
        'Ú' => 'U',
        'Ü' => 'U',
        'Ç' => 'C',
        ',' => '.',
        'R' => '',
        '$' => '',
        'r' => ''
    );
    $dinheiro = strtr($str, $map); 
    return number_format($dinheiro, 2, '.', '.');
  }
  public function ArrayUsuario(array $parans)
  {
    $Array = array('Nome' => $parans['Nome'],
        'Rua' => $parans['Rua'],
        'Numero' => $parans['Numero'],
        'Bairro' => $parans['Bairro'],
        'Cidade' => $parans['Cidade'],
        'EstadoID' => $parans['EstadoID'],
        'Email' => $parans['Email'],
        'Image' => $parans['Image'],
        'Login' => $parans['Email'],
        'Senha' => $parans['Senha'],
        'StatusID' => 0,
        'DataCadastro' => date('Y/m/d H:i:s'));
    return $Array;
  }
  
  public function ArrayUsuarioEditar(array $parans)
  {
    $Array = array('Nome' => $parans['Nome'],
        'Rua' => $parans['Rua'],
        'Numero' => $parans['Numero'],
        'Bairro' => $parans['Bairro'],
        'Cidade' => $parans['Cidade'],
        'EstadoID' => $parans['EstadoID'],
        'Email' => $parans['Email'],
        'Image' => $parans['Image'],
        'Login' => $parans['Email'],
        'Senha' => $parans['Senha']);
    return $Array;
  }
  
  public function ArrayCerveja_EDITAR(array $parans)
  {
    $Array = array('Nome' => $parans['Nome'],
        'Descricao' => $parans['Descricao'],
        'EstiloID' => $parans['EstiloID'],
        'CervejariaID' => $parans['CervejariaID'],
        'NotaModeracao' => $parans['NotaModeracao'],
        'StatusID' => $parans['StatusID'],
        'PaisID' => $parans['PaisID'],
        'Imagem' => $parans['Imagem']);
    return $Array;
  }
  
  public function ArrayCerveja(array $parans)
  {
    $Array = array('Nome' => $parans['Nome'],
        'Descricao' => $parans['Descricao'],
        'EstiloID' => $parans['EstiloID'],
        'CervejariaID' => $parans['CervejariaID'],
        'NotaModeracao' => $parans['NotaModeracao'],
        'StatusID' => $parans['StatusID'],
        'DataCadastro' => date('Y/m/d H:i:s'),
        'PaisID' => $parans['PaisID'],
        'Imagem' => $parans['Imagem']);
    return $Array;
  }
//==============================================================================================================
// Final Validadores
//==============================================================================================================  
  
///==============================================================================================================
//Manipulador de imagens
//===============================================================================================================
  public function VerificaTamanhoArquivo($file)
  {
    if($file['arquivo']['size'] >= 4000000 )
    {
      return false;
    }
    else
    {
      return true;
    }
  }
  public function VerificaNomeFoto($NomeFoto, $NomeFotoPadrao)
  {
    if($NomeFoto == $NomeFotoPadrao)
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  public function uploadDocumentos($pasta1, $pasta) 
  {
    $config = Zend_Registry::get('config');
    $upload = new Plugin_UploadHash("arquivo", $pasta1."/".$pasta."/");
    try
    {
      $upload->upload();
      return $upload;
    }
    catch(Exception $exc)
    {
      throw new Exception("Erro Upload." . $exc());
    }   
  }
  public function uploadDocumentoBYTEARRAY($data,$pasta1, $pasta)
  {
    $config = Zend_Registry::get('config');
    $data = base64_decode($data);
    $im = imagecreatefromstring($data);
    if($im !== false)
    {
      $url = md5(time() . microtime(true)) . ".jpg";
      header('Content-Type: image/jpg');
      try
      {
        imagejpeg($im, $pasta1."/".$pasta."/" . $url);
        imagedestroy($im);
        return $config->host->domain . $pasta1 ."/".$pasta."/" .$url;
      }
      catch (Exception $e)
      {
        return false;
      }
    }
    else
    {
      return false;
    }
  }
  
  public function cropar($name, $pasta1, $pasta, $xy = false, $resize = false)
  {
    $Config = Zend_Registry::get('config');
    $str = $name;
    // assume $str esteja em UTF-8
    $map = array(
            '/' => '',
            'http//' => '',
            $Config->host->domain => '',
            $pasta1.'/'.$pasta.'' =>'',
            'Usuarios' => '',
            'fotos' => '',
             );
    $foto = strtr($str, $map);
    include '../library/PhpImagizer-ver1.0/PhpImagizer.php';
    // Source file name
    $srcFileName = '' . $pasta1 . '/' . $pasta . '/' . $foto;
    try
    {
      $imagizer = new PhpImagizer($srcFileName);
      $imagizer->crop_Eu($xy['X'] ,$xy['Y'] ,$xy['Wid'],$xy['Hei']);

      if(substr_count($foto, ".PNG") > 0 || substr_count($foto, ".png") > 0)
      {
        $imagizer->saveImg('' . $pasta1 . '/' . $pasta . '/' . $foto . '');
      }
      else
      {
        $imagizer->saveImg('' . $pasta1 . '/' . $pasta . '/' . $foto . '');
      }
    }
    catch (PhpImagizerException $e)
    {
      throw new Exception('Erro' . $e->getMessage());
    }
    try
      {
        if(!empty($resize))
        {
          $imagizer->fitSize($resize['Size']);
          $imagizer->byHeight($resize['Hei']);
          $imagizer->byWidth($resize['Wid']);
        
          if(substr_count($foto, ".PNG") > 0 || substr_count($foto, ".png") > 0)
          {
            $imagizer->saveImg(''.$pasta1.'/'.$pasta.'/'.$foto.'');
          }
          else
          {
            $imagizer->saveImg(''.$pasta1.'/'.$pasta.'/'.$foto.'');
          }
        }
          
      }
      catch(PhpImagizerException $e)
      {
        throw new Exception('Erro'. $e->getMessage());
      }
    return $exts;
  }
  
  public function getExtension($name, $pasta1, $pasta, $Crop = false, $xy = false)
  {
    $Config = Zend_Registry::get('config');
    $exts = @split("[/\\.]", $name);
    $n = count($exts) - 1;
    $exts = $exts[$n];
    $str = $name;
    // assume $str esteja em UTF-8
    $map = array(
            '/' => '',
            'http//' => '',
            $Config->host->domain => '',
            $pasta1.'/'.$pasta.'' =>'',
            'Usuarios' => '',
            'fotos' => '',
             );
    $foto = strtr($str, $map);
    include '../library/PhpImagizer-ver1.0/PhpImagizer.php';
        // Source file name
    $srcFileName = ''.$pasta1.'/'.$pasta. '/' .$foto;
    try
      {
        $imagizer = new PhpImagizer($srcFileName);
        if(empty($Crop))
        {
        }
        
        else
        {
          $imagizer->fitSize($Crop['Size']);
          $imagizer->byHeight($Crop['Hei']);
          $imagizer->byWidth($Crop['Wid']);
        }
        
        if(substr_count($foto, ".PNG") > 0 || substr_count($foto, ".png") > 0)
        {
          $imagizer->saveImg(''.$pasta1.'/'.$pasta.'/'.$foto.'');
        }
        else
        {
          $imagizer->saveImg(''.$pasta1.'/'.$pasta.'/'.$foto.'');
        }
      }
      catch(PhpImagizerException $e)
      {
        throw new Exception('Erro'. $e->getMessage());
      }
      return $exts;
    }
//==============================================================================================================
//FIM Manipulador de imagens
//==============================================================================================================
}