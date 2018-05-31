<?php
/**
 * SysGen - System Generator with Formdin Framework
 * Download Formdin Framework: https://github.com/bjverde/formDin
 * 
 * @author  Bjverde <bjverde@yahoo.com.br>
 * @license https://github.com/bjverde/sysgen/blob/master/LICENSE GPL-3.0
 * @link    https://github.com/bjverde/sysgen
 *
 * PHP Version 5.6
 */
final class Message
{
    const SYSTEM_ACRONYM_INVALID = 'Sigla do sistema inválida ! Caracteres inválido (os permitidos são a-z, 0-9 _ ) ou até 50 caracteres';
    
    const GEN00_TITLE = 'Configurações do PHP e informações iniciais';
    
    const LAST_STEP = '04';
    
    const GEN01_TITLE      = 'Etapa 01 de '.self::LAST_STEP;    
    const GEN01_GPX1_TITLE = 'Requisito do PHP';
    const GEN01_GPX2_TITLE = 'Configurações de Banco';
    
    const GEN02_TITLE        = 'Etapa 02 de '.self::LAST_STEP;
    const GEN02_NOT_READY    = 'Seu Mané teste as configurações de banco!!';
    const GEN02_GPX1_TITLE   = 'Ações executadas';
    const GEN02_MKDIR_SYSTEM = 'Criada pasta base ';
    const GEN02_COPY_SYSTEM_SKELETON    = 'Copiado estrutura básica de pastas.';
    const GEN02_CREATED_CONSTANTS       = 'Criado arquivo de constantes.';
    const GEN02_CREATED_AUTOLOAD        = 'Criado arquivo de autoload do sistema.';
    const GEN02_CREATED_CONFIG_DATABASE = 'Criado arquivo de configuração de banco.';
    const GEN02_CREATED_INDEX   = 'Criado arquivo index do sistema.';
    const GEN02_REDIRECT_STEP03 = 'Você está na etapa 03 de 03. Essa parte pode demorar. Quanto maior o número de tabelas maior será demora.';
    
    const SEL_TABLES_GENERATE = 'Selecione as tabelas que deseja gerar, depois clique em: '.self::BUTTON_GEN_FORM;
    
    const GEN03_TITLE         = 'Etapa 03 de '.self::LAST_STEP;
    
    const WARNING_NO_TABLE    = 'Seu Mané, selecione as tabelas para gerar!';
    const NEW_SYSTEM_OK       = 'Sistema Criado com Sucesso';
    const CREATED_MENU        = 'Criado arquivo de menu.';
    const CREATED_TABLE_ITEN  = ' - Criado Form, Class, DAO e VO da tabela: ';
    const CREATED_VIEW_ITEN   = ' - Criado DAO e VO da view: ';
    const FIELDS_TABLE_VIEW   = ' - Lista de campos da Tabela/View: ';
    
    const GRID_LIST_FK_TITLE  = 'Lista de FK e como elas devem aparecer';
    const GPX_TYPE_CONFIG     = 'Opções de Avançada';
    const FIELD_LOGFILE_LABEL = 'Qual tipo de Log em arquivo (php_error.log) quer para o sistema?';
    const FIELD_LOGFILE_OPT00  = 'Nada será gravado no Log !!';
    const FIELD_LOGFILE_OPT01  = 'Quero tudo mesmo! até DomainException !';
    const FIELD_LOGFILE_OPT02  = 'Calma ! Quero log, SEM o DomainException!';
    
    const GEN04_TITLE        = 'Etapa 04 de '.self::LAST_STEP;
    
    const BUTTON_LABEL_BACK  = 'Voltar';
    const BUTTON_LABEL_CLEAN = 'Limpar';
    const BUTTON_GEN_FORM    = 'Gerar Telas';
    const BUTTON_LABEL_CONF  = 'Gerar Config';
}
?>
