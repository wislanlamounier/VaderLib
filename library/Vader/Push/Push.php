<?php
  class Vader_Push_Push
  {

    public static $configurado = false;
    private static $android_sender_auth_token;
    private static $ios_push_url;
    private static $ios_nome_arquivo_chave;
    private static $ios_passphrase;
    private $pushLog;
    private $tokensEnviados;
    private $tokensNaoEnviados;
    protected $_config;
    protected $respostas;

    public function __construct()
    {
      $this->_config = Zend_Registry::get('config');
      $this->configurarPush();
    }

    public function getPushLog()
    {
      return $this->pushLog;
    }
    public function getTokensEnviados()
    {
      return $this->tokensEnviados;
    }
    public function getTokensNaoEnviados()
    {
      return $this->tokensNaoEnviados;
    }

    public function getRelatorio(){
      $relatorio = array(
        "TokensEnviados" => $this->getTokensEnviados(),
        "TokensNaoEnviados" => $this->getTokensNaoEnviados(),
        "Log" => $this->getPushLog()
      );

      return $relatorio;
    }

    const IOS_PROD = "ssl://gateway.sandbox.push.apple.com:2195";
    const IOS_SANDBOX = "ssl://gateway.sandbox.push.apple.com:2195";

    public static function getIos_passphrase()
    {
      return self::$ios_passphrase;
    }
    public static function setIos_passphrase($ios_passphrase)
    {
      self::$ios_passphrase = $ios_passphrase;
    }

    public static function getAndroid_sender_auth_token()
    {
      return self::$android_sender_auth_token;
    }
    public static function getIos_push_url()
    {
      return self::$ios_push_url;
    }
    public static function getIos_nome_arquivo_chave()
    {
      return self::$ios_nome_arquivo_chave;
    }
    public static function setAndroid_sender_auth_token($android_sender_auth_token)
    {
      self::$android_sender_auth_token = $android_sender_auth_token;
    }
    public static function setIos_push_url($ios_push_url)
    {
      self::$ios_push_url = $ios_push_url;
    }
    public static function setIos_nome_arquivo_chave($ios_nome_arquivo_chave)
    {
      self::$ios_nome_arquivo_chave = $ios_nome_arquivo_chave;
    }


    /**
    CONFIGURAR AS SEGUINTES VARIAVEIS NO APPLICATION.INI
     *
    host.push_enabled = true (true ou false. Habilita ou desabilita o push)
     *
    host.push_android_api_key = AIzaSyClAheK3oGXnSX_4HGP95qtUpzSm3IwrKg (chave para push no android)
     *
    host.push_ios_file_key = votemix-desenv.pem:
    - Nome do arquivo .pem para envio de push no iOS.
    - O arquivo deve estar na pasta /files/push
    - Exemplo do caminho completo: /var/www/VotemixDesenv/files/push/votemix-desenv.pem
     *
    host.push_ios_ambiente = sandbox: servidor push iOS a ser utilizado (producao/sandbox)
     *
    host.push_ios_passphrase = mobilus: passphrase do push iOS
     *
     * PARAMETROS:
     * - tokens: um array comum de strings com os tokens dos dispositivos para disparar os pushs
     * - alerta: String que aparece para o usuario na notificacao
     * - dados: string ou json que chega no iOS na tag 'dados' (default null - nao envia esta tag)
     * - badges: numero de notificacoes
     * @author Cassio
     */
    public function sendApplePush($tokens, $alerta, $dados = null, $tipoMensagem, $badges = 1, $sound = "default")
    {
      $passphrase = $this->getIos_passphrase();
      $urlAmbiente = $this->getIos_push_url();
      $ckpemDir = $this->getIos_nome_arquivo_chave();
      $pemFile = getcwd() . "/files/push/" . $ckpemDir;


      if(!file_exists($pemFile)){
      }

      $ctx = stream_context_create();
      stream_context_set_option($ctx, 'ssl', 'local_cert', $pemFile);
      stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

      //Development: gateway.sandbox.push.apple.com:2195 ou 2196
      //Production: gateway.push.apple.com:2195 ou 2196
      // Open a connection to the APNS server
      $fp = stream_socket_client($urlAmbiente, $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

      if(!$fp)
      {

      }

      $this->addLogMessage('Connected to APNS' . PHP_EOL, "iOS");

      foreach($tokens as $deviceToken){

        // Create the payload body
        $body['aps'] = array(
          'alert' => $alerta,
          'badge' => $badges,
          'sound' => $sound
        );
        $dadosEnvio = array();
        $dadosEnvio += $dados;


        if(!empty($dados)){
          $body['aps']['dados'] = $dadosEnvio;
        }



        // Encode the payload as JSON
        $payload = json_encode($body);

        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));
        if(!$result)
        {
          $this->addLogMessage('TOKEN: ' . $deviceToken . ' Message not delivered' . PHP_EOL, "iOS");
          $this->tokensNaoEnviados[] = $deviceToken;
        }
        else
        {
          $this->addLogMessage('TOKEN: ' . $deviceToken . 'Message successfully delivered' . PHP_EOL, "iOS");
          $this->tokensEnviados[] = $deviceToken;
        }
      }
      // Close the connection to the server
      fclose($fp);
      return $this->getPushLog();
    }
    public function sendAndroidPush($tokens, $message, $dados = null, $tipoMensagem, $badges = 1, $sound = "default")
    {
      $url = 'https://android.googleapis.com/gcm/send';

      $dadosEnvio["TipoMensagem"] = $tipoMensagem;
      $dadosEnvio["Mensagem"] = $message;
      $dadosEnvio["Badges"] = $badges;
      $dadosEnvio["sound"] = $sound;
      $dadosEnvio += $dados;


      $fields = array(
        'registration_ids' => $tokens,
        'data' => (array("dados" => $dadosEnvio))
      );

      $headers = array(
        'Authorization: key=' . self::$android_sender_auth_token,
        'Content-Type: application/json'
      );

      // Open connection
      $ch = curl_init();

      // Set the url, number of POST vars, POST data
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      // Disabling SSL Certificate support temporarly
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

      // Execute post
      $result = curl_exec($ch);
      if($result === FALSE)
      {
      }
      // Close connection
      curl_close($ch);
      return $this->setResponses($result);
    }

    function addLogMessage($message, $plataforma){
      $this->pushLog .= $plataforma . " - " . date("d/m/Y H:i:s") . " -> " . $message . "\n";
    }

    private function configurarPush()
    {
      try
      {
        if(!Vader_Push_Push::$configurado)
        {
          // ANDROID
          self::setAndroid_sender_auth_token($this->_config->host->push_android_api_key);

          //IOS
          self::setIos_nome_arquivo_chave($this->_config->host->push_ios_file_key);
          self::setIos_passphrase($this->_config->host->push_ios_passphrase);

          if($this->_config->host->push_ios_ambiente == "sandbox")
            self::setIos_push_url(self::IOS_SANDBOX);
          else
            self::setIos_push_url(self::IOS_PROD);

          self::$configurado = true;
        }
      }
      catch (Exception $e)
      {
        echo "Erro ao configurar push: " . $e->getMessage();
      }
    }

    private function setResponses($json)
    {
      $respostas = new Vader_Push_ResponseAndroid();
      $respostas->setRespostas($json);
      return $respostas;
    }

  }