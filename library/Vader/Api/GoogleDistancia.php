<?php

	/**
	 * Created by PhpStorm.
	 * User: Tiaguinho
	 * Date: 16/03/2016
	 * Time: 15:50
	 */
	class Vader_Api_GoogleDistancia
	{
		protected $_array;
		protected $_endFormatado;
		protected $origem;
		protected $destino;

		protected $_cep;
		protected $lat;
		protected $long;
		protected $_config;

		protected $end_destino;
		protected $end_origem;
		protected $value;



		public function __construct()
		{
			$this->_config = Zend_Registry::get('config');
		}

		/**
		 * @param $origem -> um objeto contendo latitude e longitude
		 * @param $destinos -> um array de objetos com latitude e longitude
		 */
		public function distancia_lat_lon($origem, $destinos)
		{
			unset($this->origem);
			unset($this->destino);
			$this->format_lat_lng($origem, $destinos);
			$response = ($this->getDistancia($this->origem, $this->destinos));
			$this->_array = $response;
			$this->end_destino = $response['destination_addresses'][0];
			$this->end_origem = $response['origin_addresses'][0];
			$this->value = $response['rows'][0]['elements'][0]['distance']['value'];
		}

		public function distancia_end($end)
		{

		}

		private function format_lat_lng($origem, $destino)
		{
			$this->origem = str_replace(",",".",$origem->latitude).','.str_replace(",",".",$origem->longitude);
			$this->destinos .= str_replace(",",".",$destino->latitude).','.str_replace(",",".",$destino->longitude);
		}

		public function getDistancia($origem, $destinos)
		{
			try
			{
				$url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=$origem&destinations=$destinos&key=".$this->_config->host->google->server->key."";
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



		/**
		 * @return mixed
		 */
		public function getArray()
		{
			return $this->_array;
		}

		/**
		 * @param mixed $array
		 */
		public function setArray($array)
		{
			$this->_array = $array;
		}

		/**
		 * @return mixed
		 */
		public function getEndFormatado()
		{
			return $this->_endFormatado;
		}

		/**
		 * @param mixed $endFormatado
		 */
		public function setEndFormatado($endFormatado)
		{
			$this->_endFormatado = $endFormatado;
		}

		/**
		 * @return mixed
		 */
		public function getCep()
		{
			return $this->_cep;
		}

		/**
		 * @param mixed $cep
		 */
		public function setCep($cep)
		{
			$this->_cep = $cep;
		}

		/**
		 * @return mixed
		 */
		public function getLat()
		{
			return $this->lat;
		}

		/**
		 * @param mixed $lat
		 */
		public function setLat($lat)
		{
			$this->lat = $lat;
		}

		/**
		 * @return mixed
		 */
		public function getLong()
		{
			return $this->long;
		}

		/**
		 * @param mixed $long
		 */
		public function setLong($long)
		{
			$this->long = $long;
		}

		/**
		 * @return mixed
		 */
		public function getConfig()
		{
			return $this->_config;
		}

		/**
		 * @param mixed $config
		 */
		public function setConfig($config)
		{
			$this->_config = $config;
		}

		/**
		 * @return mixed
		 */
		public function getEndDestino()
		{
			return $this->end_destino;
		}

		/**
		 * @param mixed $end_destino
		 */
		public function setEndDestino($end_destino)
		{
			$this->end_destino = $end_destino;
		}

		/**
		 * @return mixed
		 */
		public function getEndOrigem()
		{
			return $this->end_origem;
		}

		/**
		 * @param mixed $end_origem
		 */
		public function setEndOrigem($end_origem)
		{
			$this->end_origem = $end_origem;
		}

		/**
		 * @return mixed
		 */
		public function getValue()
		{
			return $this->value;
		}

		/**
		 * @param mixed $value
		 */
		public function setValue($value)
		{
			$this->value = $value;
		}

	}