<?php
$frm = new TForm('Acesso ao Sistema',200,300);
$frm->hideCloseButton();
$frm->setFlat(true);

$frm->addHtmlField('msg','<br>');
$frm->addTextField('login'		,'Login:',20,true,20);
$frm->addPasswordField('senha'	,'Senha:',20,true,20);
$frm->addHtmlField('msg1','<br>');
//$frm->addCaptchaField('captcha',null)->setAttribute('align','center');

//$frm->addButton('Entrar','login',null);
$frm->addButtonAjax('Entrar',null,'fwValidateFields()','resultado','login','Validando informações','json',false);

$acao = isset($acao) ? $acao : null;
if( $acao =='login'){
    sleep(1);
    $nom_user = $frm->get('login');
    $pwd_user = $frm->get('senha');
    //$captcha  = $frm->get('captcha');
    
    $msg = loginService::validarLogin($nom_user,$pwd_user);
    if( $msg == 1 ) {
        $_SESSION[APLICATIVO]['conectado']=true;
        prepareReturnAjax(1);
    } else {
        $frm->setMessage('Login Invalido !');
        prepareReturnAjax(0);
    }
}

$frm->show();
?>

<script>

function resultado(res) {
    if( res.status==1) {
        fwApplicationRestart();    
    }
    else {
        fwAlert('Login Inválido');
    }
}
</script>