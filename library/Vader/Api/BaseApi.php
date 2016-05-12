<?php
class Vader_Api_BaseApi
{
  protected $_array;
  protected $_LatLon;
  protected $_rua;
  protected $_numero;
  protected $_bairro;
  protected $_cidade;
  protected $_estado;
  protected $_pais;
  protected $_endFormatado;
  protected $_cep;
  
  


  public function __construct($rua, $numero =false, $bairro, $cidade, $estado, $lat = false, $long = false)
  {
    if(empty($lat) || empty($long))
    {
      $stringFormat = new Vader_Formatadores_Strings();
      $rua = $stringFormat->ReplaceCaracteres($rua);
      $bairro = $stringFormat->ReplaceCaracteres($bairro);
      $cidade = $stringFormat->ReplaceCaracteres($cidade);
      $estado = $stringFormat->ReplaceCaracteres($estado);

      $this->_array = $this->RetornaArrayEndereco($rua, $numero, $bairro, $cidade, $estado);
      $this->_LatLon = $this->RetornaLatLong();
    }
    else
    {
      $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=false";
      $valor = file_get_contents($url);
      $jsonDecodificado = json_decode($valor, true);
      $this->_array = $jsonDecodificado;
      $this->_LatLon = $this->RetornaLatLong();
    }
    $this->setEnderecos();
  }

  public function RetornaArrayEndereco($end,$numero,$bairro,$cidade,$estado)
  {
    $ConcatenacaoEnde = $this->CactenarEndereco($end,$numero,$bairro,$cidade,$estado);
    $Endereco = $this->TirarEspacoEmBranco($ConcatenacaoEnde);

    try
    {
      $url = "http://maps.google.com/maps/api/geocode/json?address=$Endereco&sensor=false&region=";
      $valor = file_get_contents($url);
      $jsonDecodificado = json_decode($valor, true);
    }
    catch (Exception $e)
    {
      throw new Exception('Alguma coisa deu errada');
    }
    return $jsonDecodificado;
  }
  
  private function CactenarEndereco($end,$numero, $bairro,$cidade,$estado)
  {
    $resultado = $end.'%20'.$numero.'%20'.$bairro.'%20'.$cidade.'%20'.$estado;
    return $resultado;
  }
  
  private function TirarEspacoEmBranco($end)
  {
    $Resposta=str_replace(" ","%20",$end);
    return $Resposta;
  }
  
  public function RetornaLatLong()
  {
    $lat = $this->_array['results'][0]['geometry']['location']['lat'];
    $long = $this->_array['results'][0]['geometry']['location']['lng'];
    return array('Lat' => $lat, 'Long' => $long);
  }
  public function RetornaCEP($array)
  {
    $Cep = $array['results'][0]['address_components'][7]['long_name'];
    return $Cep;
  }
  
  private function setEnderecos()
  {
    $this->set_numero($this->_array['results'][0]['address_components'][0]['long_name']);
    $this->set_rua($this->_array['results'][0]['address_components'][1]['long_name']);
    $this->set_bairro($this->_array['results'][0]['address_components'][2]['long_name']);
    $this->set_cidade($this->_array['results'][0]['address_components'][3]['short_name']);
    $this->set_estado($this->_array['results'][0]['address_components'][5]['short_name']);
    $this->set_pais($this->_array['results'][0]['address_components'][6]['short_name']);
    $this->set_cep($this->_array['results'][0]['address_components'][7]['short_name']);
    $this->set_endFormatado($this->_array['results'][0]['formatted_address']);
  }
  
  function isEnderecoCompleto()
  {
    if(empty($this->_rua) ||
        empty($this->_bairro) ||
        empty($this->_cidade) ||
        empty($this->_estado))
    {
      return false;
    }
    else
    {
      return true;
    }
  }

  function distance($lat1, $lon1, $lat2, $lon2, $unit) {

    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
      return ($miles * 1.609344);
    } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
      return $miles;
    }
  }
  
  //<editor-fold defaultstate="collapsed" desc="Get And Sets">
  function get_array()
  {
    return $this->_array;
  }

  function get_LatLon()
  {
    return $this->_LatLon;
  }

  function get_rua()
  {
    return $this->_rua;
  }

  function get_bairro()
  {
    return $this->_bairro;
  }

  function get_cidade()
  {
    return $this->_cidade;
  }

  function get_estado()
  {
    return $this->_estado;
  }

  function set_array($_array)
  {
    $this->_array = $_array;
  }

  function set_LatLon($_LatLon)
  {
    $this->_LatLon = $_LatLon;
  }

  function set_rua($_rua)
  {
    $this->_rua = $_rua;
  }

  function set_bairro($_bairro)
  {
    $this->_bairro = $_bairro;
  }

  function set_cidade($_cidade)
  {
    $this->_cidade = $_cidade;
  }

  function set_estado($_estado)
  {
    $this->_estado = $_estado;
  }
  function get_pais()
  {
    return $this->_pais;
  }

  function set_pais($_pais)
  {
    $this->_pais = $_pais;
  }
  function get_endFormatado()
  {
    return $this->_endFormatado;
  }

  function set_endFormatado($_endFormatado)
  {
    $this->_endFormatado = $_endFormatado;
  }

  function get_numero()
  {
    return $this->_numero;
  }

  function set_numero($_numero)
  {
    $this->_numero = $_numero;
  }
  
  function get_cep()
  {
    return $this->_cep;
  }

  function set_cep($_cep)
  {
    $this->_cep = $_cep;
  }
  
  //</editor-fold>
}
