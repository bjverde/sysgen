<?php
final class Message {
	const SYSTEM_ACRONYM_INVALID = 'Sigla do sistema inválida ! Caracteres inválido (os permitidos são a-z, 0-9 _ ) ou até 50 caracteres';
	
	const GEN00_TITLE = 'Configurações do PHP e informações iniciais';
	
	const GEN01_TITLE      = 'Etapa 01 de 03';	
	const GEN01_GPX1_TITLE = 'Requisito do PHP';
	const GEN01_GPX2_TITLE = 'Configurações de Banco';
	
	const GEN02_TITLE        = 'Etapa 02 de 03';
	const GEN02_GPX1_TITLE   = 'Ações executadas';
	const GEN02_MKDIR_SYSTEM = 'Criada pasta base ';
	const GEN02_COPY_SYSTEM_SKELETON = 'Copiado estrutura básica de pastas.';
	const GEN02_CREATED_CONSTANTS = 'Criado arquivo de constantes.';
	const GEN02_CREATED_CONFIG_DATABASE = 'Criado arquivo de configuração de banco.';
	const GEN02_CREATED_MENU = 'Criado arquivo de menu.';
	
}
?>