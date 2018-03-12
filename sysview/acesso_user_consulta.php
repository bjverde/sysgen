<?php

defined('APLICATIVO') or die();

$primaryKey = 'ICODIGOGRUPO';
$frm = new TForm('Lista de usuário com Acesso ao sistema',600,900);
$frm->setFlat(true);
$frm->setMaximize(true);

$frm->addHiddenField( $primaryKey ); // coluna chave da tabela

$dados = Mpdft_v_grupo_usuario_sistemaDAO::selectAll($primaryKey,'iCodigoSistema='.ICODIGOSISTEMA);

$mixUpdateFields = $primaryKey.'|'.$primaryKey.',SDESCRICAOGRUPO|SDESCRICAOGRUPO,SNOMESISTEMA|SNOMESISTEMA,IUSUARIO|IUSUARIO,SNOMEUSUARIO|SNOMEUSUARIO';
$gride = new TGrid( 'gd'          // id do gride
                  , 'Gride'       // titulo do gride
                  , $dados 	      // array de dados
                  , null		  // altura do gride
                  , null		  // largura do gride
                  , $primaryKey   // chave primaria
                  , $mixUpdateFields
                  );
$gride->addColumn($primaryKey,'id Grupo',10,'center');
$gride->addColumn('SDESCRICAOGRUPO','Grupo',150,'left');
$gride->addColumn('IUSUARIO','id Usuario',10,'center');
$gride->addColumn('SNOMEUSUARIO','Nome',150,'left');
$gride->enableDefaultButtons(false);
$frm->addHtmlField('gride',$gride);
$frm->show();
?>