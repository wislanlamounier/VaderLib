<?php
class Default_Form_Crudes
{
  private function getModel($tipo, $parans, $acao, $where = null)
  {
    switch ($tipo) 
    {
    case 0:
        return $this->Obras($parans, $acao, $where);
    case 1:
        return $this->Cliente($parans, $acao, $where);
    case 2:
        return $this->Estados($parans, $acao, $where);
    case 3:
      return  $this->Ocorrencias($parans, $acao, $where);
    case 4:
      return  $this->TipoOcorrencia($parans, $acao, $where);
    case 5:
      return  $this->TipoOcorrenciaTipoEstaca($parans, $acao, $where);
    case 6:
      return $this->TipoAlertas($parans, $acao, $where);
    case 7:
      return $this->Usuarios($parans, $acao, $where);
    case 8:
      return $this->Estacas($parans, $acao, $where);
    case 9:
      return $this->TipoEstacas($parans, $acao, $where);
    case 10:
      return $this->Equipamento($parans, $acao, $where);
      }
  }
  
  /**
   * 
   * @param type $tipo, EXEMPLOS qual entidade pertence. 0 -> Usuario, 1 -> Cliente, 2-> Estaca, 3->Tipo Ocorrencia
   * @param type array $parans Array para salvar no banco de dados.
   * 
   */
  public function insert($tipo, $parans)
  {
    try
    {
      $Resultado = $this->getModel($tipo, $parans, 1);
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }
    return $Resultado;
  }
  
  /**
   * 
   * @param type $tipo, EXEMPLOS qual entidade pertence. 0 -> Usuario, 1 -> Cliente, 2-> Estaca, 3->Tipo Ocorrencia
   * @param type array $parans Array para salvar no banco de dados.
   * 
   */
  public function editar($tipo, $parans, $where)
  {
    try
    {
      $Resultado = $this->getModel($tipo, $parans, 2, $where);
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }
    return $Resultado;
  }
  
  /**
   * 
   * @param type $tipo, EXEMPLOS qual entidade pertence. 0 -> Usuario, 1 -> Cliente, 2-> Estaca, 3->Tipo Ocorrencia
   * @param type $where
   * 
   */
  public function get($tipo, $where)
  {
    try
    {
      $Resultado = $this->getModel($tipo, null,0 ,$where);
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }
    return $Resultado;
  }
  
  /**
   * 
   * @param type $tipo, EXEMPLOS qual entidade pertence. 0 -> Usuario, 1 -> Cliente, 2-> Estaca, 3->Tipo Ocorrencia
   * @param type $where
   * 
   */
  public function excluir($tipo, $where)
  {
    try
    {
      $Resultado = $this->getModel($tipo, null,4 ,$where);
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }
    return $Resultado;
  }
  
  private function Cliente($parans, $acao, $where = null)
  {
    $obj = new Application_Model_DbTable_cliente();
    if(!empty($parans))
    {
      $this->VerificaCampos(array($parans['NomeEmpresa'],$parans['NomeContato'],$parans['Email'],$parans['Telefone'], $parans['CNPJ'], $parans['Rua'], $parans['Numero'], $parans['Bairro']));
      $data = $this->ArrayCliente($parans);
    }
    try
    {
      if($acao == 1)
      {
        $retorno = $obj->insert($data);
        return $retorno;
      }
      else if($acao == 2)
      {
        $retorno = $obj->update($data, $where);
        return $retorno;
      }
      else if($acao == 0)
      {
        if($where != null)
          $retorno = $obj->fetchAll($obj->select()->where($where))->toArray();
        else
          $retorno = $obj->fetchAll($obj->select())->toArray();
        return $retorno;
      }
      else if($acao  == 4)
      {
        $retorno = $obj->delete($where);
        return $retorno;
      }
    }
    catch (Exception $e)
    {
      throw new Exception ('ERRO: 99');
    }
  }
  
  public function VerificaCampos($campos)
  {
    $obj = new Default_Form_Cadastro();
    if($obj->Validarpreenchido($campos) == FALSE)
    {
      throw new Exception (ErroPreenchimento);
    }
  }
  
  private function ArrayCliente($parans)
  {
    $array = array('CNPJ' => $parans['CNPJ'],
        'Telefone'=>$parans['Telefone'],
        'Email' => $parans['Email'],
        'NomeContato' => $parans['NomeContato'],
        'NomeEmpresa' => $parans['NomeEmpresa'],
        'Rua' => $parans['Rua'],
        'Cidade' => $parans['Cidade'],
        'Numero' => $parans['Numero'],
        'Complemento' => $parans['Complemento'],
        'Bairro' => $parans['Bairro'],
        'EstadoID' => $parans['EstadoID']);
    return $array;
  }
    
  private function Obras($parans, $acao, $where = null)
  {
    $obj = new Application_Model_DbTable_obra();
    if(!empty($parans))
    {
      $this->VerificaCampos(array($parans['EmpresaID'], $parans['EstadoID'], $parans['Rua'], $parans['Numero'], $parans['Bairro']));
      $data = $this->ArrayObras($parans);
    }
    try
    {
      if($acao == 1)
      {
        $retorno = $obj->insert($data);
        return $retorno;
      }
      else if($acao == 2)
      {
        $retorno = $obj->update($data, $where);
        return $retorno;
      }
      else if($acao == 0)
      {
        if($where != null)
          $retorno = $obj->fetchAll($obj->select()->where($where))->toArray();
        else
          $retorno = $obj->fetchAll($obj->select())->toArray();
        return $retorno;
      }
      else if($acao  == 4)
      {
        $retorno = $obj->delete($where);
        return $retorno;
      }
    }
    catch (Exception $e)
    {
      throw new Exception ('ERRO: 99');
    }
  }
     
  private function ArrayObras($parans)
  {
    $array = array('EmpresaID' => $parans['EmpresaID'],
        'CodigoObra' => $parans['CodigoObra'],
        'NomeObra' => $parans['NomeObra'],
        'Rua' => $parans['Rua'],
        'Numero' => $parans['Numero'],
        'Cidade'=>$parans['Cidade'],
        'Complemento' => $parans['Complemento'],
        'Bairro' => $parans['Bairro'],
        'EstadoID' => $parans['EstadoID'],
        'StatusID' => $parans['StatusID']);
    return $array;
  }
  
  private function Ocorrencias($parans, $acao, $where = null)
  {
    $obj = new Application_Model_DbTable_ocorrencia();
    if(!empty($parans))
    {
      $this->VerificaCampos(array($parans['EmpresaID'], $parans['EstadoID'], $parans['Rua'], $parans['Numero'], $parans['Bairro']));
      $data = $this->ArrayObras($parans);
    }
    try
    {
      if($acao == 1)
      {
        $retorno = $obj->insert($data);
        return $retorno;
      }
      else if($acao == 2)
      {
        $retorno = $obj->update($data, $where);
        return $retorno;
      }
      else if($acao == 0)
      {
        if($where != null)
          $retorno = $obj->fetchAll($obj->select()->where($where))->toArray();
        else
          $retorno = $obj->fetchAll($obj->select())->toArray();
        return $retorno;
      }
      else if($acao  == 4)
      {
        $retorno = $obj->delete($where);
        return $retorno;
      }
    }
    catch (Exception $e)
    {
      throw new Exception ('ERRO: 99');
    }
  }
  
  private function TipoOcorrencia($parans, $acao, $where = null)
  {
    $obj = new Application_Model_DbTable_tipoocorrencia();
    if(empty($parans['TipoEstacaID']) && $acao == 1)
    {
      throw new Exception('Estaca deve selecionar pelo menos uma');
    }
    else      
    {
      try
      {
        if(!empty($parans))
        {
          $this->VerificaCampos(array($parans['Nome'], $parans['Descricao']));

          $data = $this->ArrayTipoOcorrencia($parans);
        }
        if($acao == 1)
        {
          $retorno = $obj->insert($data);
          return $retorno;
        }
        else if($acao == 2)
        {
          $retorno = $obj->update($data, $where);
          return $retorno;
        }
        else if($acao == 0)
        {
          if($where != null)
            $retorno = $obj->fetchAll($obj->select()->where($where))->toArray();
          else
            $retorno = $obj->fetchAll($obj->select())->toArray();
          return $retorno;
        }
        else if($acao  == 4)
        {
          $retorno = $obj->delete($where);
          return $retorno;
        }
      }
      catch (Exception $e)
      {
        throw new Exception ('ERRO: 99');
      }
    }
  }
  
  private function ArrayTipoOcorrencia($parans)
  {
    $array = array('Nome' => $parans['Nome'],
        'FlagTipoOcorrencia' => $parans['FlagTipoOcorrencia'],
        'Descricao' => $parans['Descricao']);
    return $array;
  }
  
  private function TipoOcorrenciaTipoEstaca($parans, $acao, $where = null)
  {
    $obj = new Application_Model_DbTable_tipoocorrenciatipoestaca();
    try
    {
      if($acao == 1)
      {
        foreach($parans['TipoEstacaID'] as $TipoEstacaID)
        {
          $data = array('TipoOcorrenciaID' => $parans['TipoOcorrenciaID'],
          'TipoEstacaID' => $TipoEstacaID);
          $retorno[] = $obj->insert($data);
        }
        return $retorno;
      }
      else if($acao == 2)
      {
        $retorno = $obj->update($data, $where);
        return $retorno;
      }
      else if($acao == 0)
      {
        if($where != null)
          $retorno = $obj->fetchAll($obj->select()->where($where))->toArray();
        else
          $retorno = $obj->fetchAll($obj->select())->toArray();
        return $retorno;
      }
      else if($acao  == 4)
      {
        $retorno = $obj->delete($where);
        return $retorno;
      }
    }
    catch (Exception $e)
    {
      throw new Exception ('ERRO: 99');
    }
  }
  
  private function TipoAlertas($parans, $acao, $where = null)
  {
    $obj = new Application_Model_DbTable_tipoalerta();
    try
    {
      $data = array('Nome' => $parans['Nome'],
            'Descricao' => $parans['Descricao']);
      if($acao == 1)
      {
        $retorno = $obj->insert($data);
        return $retorno;
      }
      else if($acao == 2)
      {
        $retorno = $obj->update($data, $where);
        return $retorno;
      }
      else if($acao == 0)
      {
        if($where != null)
          $retorno = $obj->fetchAll($obj->select()->where($where))->toArray();
        else
          $retorno = $obj->fetchAll($obj->select())->toArray();
        return $retorno;
      }
      else if($acao  == 4)
      {
        $retorno = $obj->delete($where);
        return $retorno;
      }
    }
    catch (Exception $e)
    {
      throw new Exception ('ERRO: 99');
    }
  }
  
  private function Usuarios($parans, $acao, $where = null)
  {
    $obj = new Application_Model_DbTable_usuario();
    try
    {
      if($parans['TipoUsuarioID'] == null)
        $TipoUsuarioID = 0;
      else
        $TipoUsuarioID = $parans['TipoUsuarioID'];
      
      if($acao == 1)
      {
        $data = array('CargoID' => $parans['CargoID'],
            'Telefone' => $parans['Telefone'],
            'Nome' => $parans['Nome'],
          'Senha' => sha1($parans['Senha']),
          'Email' => $parans['Email'],
          //'TipoUsuarioID' => $TipoUsuarioID
          );
        $validaCampos = $this->VerificaCampos(array($parans['Telefone'],$parans['Nome'],$parans['Email'],$parans['Senha']));
        $ValidaSenha = $this->CamposIguais($parans['Senha'], $parans['ConfSenha'], 'senha');
        $ValidaEmail = $this->CamposIguais($parans['Email'], $parans['ConfEmail'], 'email');
        $ValidaEmailCadastro = $this->VerificaEmailBASE($parans['ConfEmail']);
        $retorno = $obj->insert($data);
        return $retorno;
      }
      else if($acao == 2)
      {
        $data = array('CargoID' => $parans['CargoID'],
            'Telefone' => $parans['Telefone'],
            'Email' => $parans['Email'],
            'Nome' => $parans['Nome'],
          'TipoUsuarioID' => $TipoUsuarioID);
        $retorno = $obj->update($data, $where);
        return $retorno;
      }
      else if($acao == 0)
      {
        if($where != null)
          $retorno = $obj->fetchAll($obj->select()->where($where))->toArray();
        else
          $retorno = $obj->fetchAll($obj->select())->toArray();
        return $retorno;
      }
      else if($acao  == 4)
      {
        $retorno = $obj->delete($where);
        return $retorno;
      }
    }
    catch (Exception $e)
    {
      throw new Exception ($e->getMessage());
    }
  }
  
  private static function CamposIguais ($campoX, $CampoY, $NomeCampo)
  {
    $obj = new Default_Form_Cadastro();
    if($obj->CamposIguais($campoX, $CampoY) == true)
            return true;
    else
      throw new Exception('Campo '.$NomeCampo.' não está correto.');
  }
  
  private function VerificaEmailBASE ($valor)
  {
    $obj = new Application_Model_DbTable_usuario();
    try
    {
      $resultado = $obj->getUsuariobyEmail($valor);
      if(empty($resultado))
        return true;
      else
      {
        throw new Exception('Email já se encontra na base de dados');
      }
        
    }
    catch (Exception $e)
    {
      throw new Exception ($e->getMessage());
    }
  }
  
  private function Estacas($parans, $acao, $where = null)
  {
    $obj = new Application_Model_DbTable_estaca();
    try
    {
      
      if($acao == 1)
      {
        try
        {
          $retorno = $obj->insert($parans);
        }
        catch (Exception $e)
        {
          throw new Exception('Erro na hora de incluir na base de dados.');
        }
        return $retorno;
      }
      else if($acao == 2)
      {
        try
        {
          $retorno = $obj->update($parans, $where);
        }
        catch (Exception $e)
        {
          throw new Exception('Não foi possivel editar');
        }
        return $retorno;
      }
      else if($acao == 0)
      {
        if($where != null)
          $retorno = $obj->fetchAll($obj->select()->where($where))->toArray();
        else
          $retorno = $obj->fetchAll($obj->select())->toArray();
        return $retorno;
      }
      else if($acao  == 4)
      {
        $retorno = $obj->delete($where);
        return $retorno;
      }
    }
    catch (Exception $e)
    {
      throw new Exception ($e->getMessage());
    }
  }
  
  private function TipoEstacas($parans, $acao, $where = null)
  {
    $obj = new Application_Model_DbTable_tipoestaca();
    try
    {
      if($parans['TipoUsuarioID'] == null)
        $TipoUsuarioID = 0;
      else
        $TipoUsuarioID = $parans['TipoUsuarioID'];
      
      if($acao == 1)
      {
        $data = array('CPF' => $parans['CPF'],
            'Nome' => $parans['Nome'],
          'Senha' => sha1($parans['Senha']),
          'Email' => $parans['Email'],
          'TipoUsuarioID' => $TipoUsuarioID);
        $validaCampos = $this->VerificaCampos(array($parans['CPF'],$parans['Nome'],$parans['Email'],$parans['Senha']));
        $ValidaSenha = $this->CamposIguais($parans['Senha'], $parans['ConfSenha'], 'senha');
        $ValidaEmail = $this->CamposIguais($parans['Email'], $parans['ConfEmail'], 'email');
        $ValidaEmailCadastro = $this->VerificaEmailBASE($parans['ConfEmail']);
        $retorno = $obj->insert($data);
        return $retorno;
      }
      else if($acao == 2)
      {
        $data = array('CPF' => $parans['CPF'],
            'Nome' => $parans['Nome'],
          'TipoUsuarioID' => $TipoUsuarioID);
        $retorno = $obj->update($data, $where);
        return $retorno;
      }
      else if($acao == 0)
      {
        if($where != null)
          $retorno = $obj->fetchAll($obj->select()->where($where))->toArray();
        else
          $retorno = $obj->fetchAll($obj->select())->toArray();
        return $retorno;
      }
      else if($acao  == 4)
      {
        $retorno = $obj->delete($where);
        return $retorno;
      }
    }
    catch (Exception $e)
    {
      throw new Exception ($e->getMessage());
    }
  }
  
  public function Equipamento($parans, $acao, $where = null)
  {
    $obj = new Application_Model_DbTable_equipamento();
    try
    {
      
      if($acao == 1)
      {
        $data = array('Descricao' => $parans['Descricao'],
            'Codigo' => $parans['Codigo']);
        $validaCampos = $this->VerificaCampos(array($parans['Descricao'],$parans['Codigo']));
        $retorno = $obj->insert($data);
        return $retorno;
      }
      else if($acao == 2)
      {
        $data = array('Descricao' => $parans['Descricao'],
            'Codigo' => $parans['Codigo']);
        $retorno = $obj->update($data, $where);
        return $retorno;
      }
      else if($acao == 0)
      {
        if($where != null)
          $retorno = $obj->fetchAll($obj->select()->where($where))->toArray();
        else
          $retorno = $obj->fetchAll($obj->select())->toArray();
        return $retorno;
      }
      else if($acao  == 4)
      {
        $retorno = $obj->delete($where);
        return $retorno;
      }
    }
    catch (Exception $e)
    {
      throw new Exception ($e->getMessage());
    }
  }
  
}