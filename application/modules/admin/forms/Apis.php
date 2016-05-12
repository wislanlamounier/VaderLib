<?php
class Admin_Form_Apis
{
  /**
   * Api do google que retorna o Json de reposta
   * @url http://maps.google.com/maps/api/geocode/json?address=itibere%20da%20cunha/36%20Estrela%20dalva%20Belo%20Horizonte%20Minas%20Gerais&sensor=false&region=
   * @param type $end
   * @param type $bairro
   * @param type $cidade
   * @param type $estado
   */
  
  public function RetornaArrayEndereco($end,$bairro,$cidade,$estado)
  {
    $log = new Default_Form_Log();
    $ConcatenacaoEnde = $this->CactenarEndereco($end,$bairro,$cidade,$estado);
    $Endereco = $this->TirarEspacoEmBranco($ConcatenacaoEnde);
    
    try
    {
      $url = "http://maps.google.com/maps/api/geocode/json?address=$Endereco&sensor=false&region=";
      $valor = file_get_contents($url);
      $jsonDecodificado = json_decode($valor, true);
      $log->inserir('Google Apis', $jsonDecodificado['status'], $valor);
    }
    catch (Exception $e)
    {
      throw new Exception('Alguma coisa deu errada');
    }
    return $jsonDecodificado;
  }
  
  private function CactenarEndereco($end,$bairro,$cidade,$estado)
  {
    $resultado = $end.'%20'.$bairro.'%20'.$cidade.'%20'.$estado;
    return $resultado;
  }
  
  private function TirarEspacoEmBranco($end)
  {
    $Resposta=str_replace(" ","%20",$end);
    return $Resposta;
  }
  
  public function RetornaLatLong($array)
  {
    $lat = $array['results'][0]['geometry']['bounds']['northeast']['lat'];
    $long = $array['results'][0]['geometry']['bounds']['northeast']['lng'];
    return array('Lat' => $lat, 'Long' => $long);
  }
  public function RetornaCEP($array)
  {
    $Cep = $array['results'][0]['address_components'][7]['long_name'];
    return $Cep;
  }
}