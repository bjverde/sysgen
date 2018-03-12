<?php

defined('APLICATIVO') or die();

$primaryKey = 'IDPESSOA';
$frm = new TForm('Cadastro de Pessoa',600);
$frm->setFlat(true);
$frm->setMaximize(true);

$frm->addHiddenField( $primaryKey ); // coluna chave da tabela
$frm->addTextField('NMPESSOA', 'Nome da Pessoa',50,true);
$frm->addSelectField('TPPESSOA', 'Tipo Pessoa:',null,'F=Pessoa física,J=Pessoa jurídica',false)->addEvent('onChange','select_change(this)');



$pc = $frm->addPageControl('pc',100,null,null,null);

$pc->addPage('Pessoa Física',false,true,'pessoaFisica',true,true);
$frm->addCpfField('NMCPF','CPF:',false);
$frm->addTextField('IDUF', 'UF',50,false);
$frm->addTextField('IDESTADOCIVIL', 'Estado Civil',50,false);
$frm->addTextField('IDNACIONALIDADE', 'Nacionalidade',50,false);


$pc->addPage('Pessoa Jurídica',false,true,'pessoaJuridica',true,true);
$frm->addCnpjField('NMCNPJ','CNPJ:',false);

$frm->closeGroup();


$frm->addButton('Salvar', null, 'Salvar', null, null, true, false);
$frm->addButton('Limpar', null, 'Limpar', null, null, false, false);

function salvar($frm){
    if ( $frm->validate() ) {
        $vo = new PessoaVO();
        $frm->setVo( $vo );
        $resultado = PessoaDAO::insert( $vo );
        if($resultado==1) {
            $frm->setMessage('Registro gravado com sucesso!!!');
            $frm->clearFields();
        }else{
            $frm->setMessage($resultado);
        }
    }
}


$acao = isset($acao) ? $acao : null;
switch( $acao ) {
    case 'Salvar':
        $TPPESSOA = $frm->get('TPPESSOA');
        if ( $TPPESSOA == 'F' ) {
            $cpf = $frm->get('NMCPF');
            if(empty($cpf)){
                $frm->setFocusField('NMCPF');
                $frm->setMessage('Informe o CPF');
            }else{
                salvar($frm);
            }
        }else{
            $cnpj = $frm->get('NMCNPJ');
            if(empty($cnpj)){
                $frm->setFocusField('NMCNPJ');
                $frm->setMessage('Informe o CNPJ');
            }else{
                salvar($frm);
            }
        }
        break;
        //--------------------------------------------------------------------------------
    case 'Limpar':
        $frm->clearFields();
        break;
        //--------------------------------------------------------------------------------
    case 'gd_excluir':
        $id = $frm->get( $primaryKey ) ;
        $resultado = PessoaDAO::delete( $id );;
        if($resultado==1) {
            $frm->setMessage('Registro excluido com sucesso!!!');
            $frm->clearFields();
        }else{
            $frm->clearFields();
            $frm->setMessage($resultado);
        }
        break;
}

$dados = PessoaDAO::selectAll($primaryKey);
$mixUpdateFields = $primaryKey.'|'.$primaryKey.',NMPESSOA|NMPESSOA,TPPESSOA|TPPESSOA,NMCNPJ|NMCNPJ,NMCPF|NMCPF';
$gride = new TGrid( 'gd'        // id do gride
    ,'Gride'     // titulo do gride
    ,$dados 	      // array de dados
    ,null		  // altura do gride
    ,null		  // largura do gride
    ,$primaryKey   // chave primaria
    ,$mixUpdateFields
    );
$gride->addColumn($primaryKey,'id',50,'center');
$gride->addColumn('NMPESSOA','Nome',100,'center');
$gride->addColumn('TPPESSOA','Tipo',50,'center');
$gride->addColumn('NMCNPJ','CNPJ',15,'center');
$gride->addColumn('NMCPF','CPF',13,'center');
$gride->addColumn('IDUF','UF',13,'center');
$gride->addColumn('IDESTADOCIVIL','Estado Civil',50,'center');
$gride->addColumn('IDNACIONALIDADE','UF','Nacionalidade','center');
$frm->addHtmlField('gride',$gride);
$frm->show();
?>
<script>
function select_change(e) {
	if( e.id == 'TPPESSOA'){
		var valor = jQuery("#"+e.id).find(":selected").val();
		if (valor=='F'){
			fwSetRequired('NMCPF');
			fwHabilitarAba('pessoaFisica','pc');
			fwSelecionarAba('pessoaFisica');
			fwDesabilitarAba('pessoaJuridica');
		}else{
			fwSetRequired('NMCNPJ');
			fwHabilitarAba('pessoaJuridica','pc');
			fwSelecionarAba('pessoaJuridica');
			fwDesabilitarAba('pessoaFisica');
		}
	}
}
</script>