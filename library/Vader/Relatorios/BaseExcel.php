<?php
class Vader_Relatorios_BaseExcel
{
  protected $cabecalho;
  protected $corpo;
  protected $apelidos;
  protected $campo;
  protected $nomeArquivo;
  

  

  private function setCabecalho(&$campos)
  {
    $html .= "<tr>";
    $campos = $this->verificarApelido($campos);
    foreach($campos as $chave => $valor)
    {
      if(array_key_exists($chave, $this->apelidos))
      {
        if($this->apelidos[$chave] != null)
        {
          if(!is_array($valor))
          {
            $html .= "<td><b>".utf8_decode($this->apelidos[$chave])."</b></td>";
          }
        }
        else
        {
          unset($campos[$chave]);
        }
      }
      else
      {
        if(!is_array($valor))
            $html .= "<td><b>".utf8_decode($chave)."</b></td>";
      }
    }
    
    $html .= "</tr>";
    $this->cabecalho = $html;
    return $html;
  }
  
  private function verificarApelido($dados)
  {
    foreach($dados as $chave => $valor)
    {
      if(!is_array($valor))
      {
        if(array_key_exists($chave, $this->apelidos))
        {
          if($this->apelidos[$chave] == null)
          {
            unset($dados[$chave]);
          }
        }
      }
      
      else
      {
        $tamanhoArray = count($dados[$chave]);
        for($i = 0; $i <= $tamanhoArray; $i++ )
        {
          foreach($dados[$chave][$i] as $key => $value)
          {
            if(array_key_exists($key, $this->apelidos))
            {
              if($this->apelidos[$key] == null)
              {
                unset($dados[$chave][$i][$key]);
              }
            }
          }
        }
      }
      
    }
    return $dados;
  }
  
  public function getExcel($obj)
  {
    $tabela .= "";
    $tabela .="<table BORDER=1>";
    
    $dados = (array)$obj;
    
    $cabecalho = $this->setCabecalho($dados);
    $corpo = $this->setCorpo($dados);
    
    $tabela .= $cabecalho;
    $tabela .= $corpo;
    if(!$this->nomeArquivo)
      $this->nomeArquivo = date('Y-m-d').'.xls';
    
    header("Content-Type:application/x-msexcel; charset=utf-8");
    header("Content-Disposition: attachment; filename={$this->nomeArquivo}");
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);
    
    echo $tabela;exit;
  }
  
  function getCabeçalho()
  {
    return $this->cabeçalho;
  }

  function getCorpo()
  {
    return $this->corpo;
  }

  function setCorpo($dados)
  {
    foreach($dados as $key => $value)
    {
      if(empty($value))
        $value = '--------';
      
      if(!is_array($value))
      {
        $html .= '<td><b>'.utf8_decode($value).'</b></td>';
      }
      else
      {
        $html .= "<TR><TD colspan='".(count($value[0]))."' style='text-align: center;font-size: 20px'><b>".utf8_decode($key)."</b></TD></tr>";
        $html .= $this->setCabecalho($value[0]);
        foreach($value as $campo => $valorCampo)
        {
          $html .= '<tr>'. $this->setCorpo($valorCampo) .'</tr>';
        }
      }
      
    }
    return $html;
  }
  
  function getApelidos()
  {
    return $this->apelidos;
  }

  function setApelidos($apelidos)
  {
    $this->apelidos = $apelidos;
  }
  
  function getCampo()
  {
    return $this->campo;
  }

  function getNomeArquivo()
  {
    return $this->nomeArquivo;
  }

  function setCampo($campo)
  {
    $this->campo = $campo;
  }

  function setNomeArquivo($nomeArquivo)
  {
    $this->nomeArquivo = $nomeArquivo;
  }
}