<?php
/**
 * SysGen - System Generator with Formdin Framework
 * https://github.com/bjverde/sysgen
 */
final class Message {
	const SYSTEM_ACRONYM_INVALID = 'Sigla do sistema inválida ! Caracteres inválido (os permitidos são a-z, 0-9 _ ) ou até 50 caracteres';
	
	const GEN00_TITLE = 'Configurações do PHP e informações iniciais';
	
	const GEN01_TITLE      = 'Etapa 01 de 03';	
	const GEN01_GPX1_TITLE = 'Requisito do PHP';
	const GEN01_GPX2_TITLE = 'Configurações de Banco';
	
	const GEN02_TITLE        = 'Etapa 02 de 03';
	const GEN02_NOT_READY    = 'Seu Mané teste as configurações de banco!!';
	const GEN02_GPX1_TITLE   = 'Ações executadas';
	const GEN02_MKDIR_SYSTEM = 'Criada pasta base ';
	const GEN02_COPY_SYSTEM_SKELETON    = 'Copiado estrutura básica de pastas.';
	const GEN02_CREATED_CONSTANTS       = 'Criado arquivo de constantes.';
	const GEN02_CREATED_AUTOLOAD        = 'Criado arquivo de autoload do sistema.';
	const GEN02_CREATED_CONFIG_DATABASE = 'Criado arquivo de configuração de banco.';
	const CREATED_MENU  = 'Criado arquivo de menu.';
	const GEN02_CREATED_INDEX = 'Criado arquivo index do sistema.';
	const GEN02_REDIRECT_STEP03 = 'Você está na etapa 03 de 03. Essa parte pode demorar. Quanto maior o número de tabelas maior a demora.';
	
	const GEN03_TITLE         = 'Etapa 03 de 03';
	const GEN03_NOT_READY     = 'Seu Mané, selecione as tabelas para gerar!';
	const GEN03_NEW_SYSTEM_OK = 'Sistema Criado com Sucesso';
}
?>