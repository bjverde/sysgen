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
    const SYSTEM_ACRONYM_INVALID = 'Sigla do sistema inválida ! Caracteres inválido (os permitidos são a-z, 0-9, _ ) ou até 50 caracteres';
    
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
    
    const SEL_TABLES_GENERATE = 'Selecione as tabelas que deseja gerar, depois clique em: '.self::BUTTON_LABEL_CONF;
    
    const GEN03_TITLE         = 'Etapa 03 de '.self::LAST_STEP;
    
    const WARNING_NO_TABLE    = 'Seu Mané, selecione as tabelas para gerar!';
    const NEW_SYSTEM_OK       = 'Sistema Criado com Sucesso';
    const CREATED_MENU        = 'Criado arquivo de menu.';
    const CREATED_API_INDEX   = 'Criado arquivo de index e routes da API';
    const CREATED_TABLE_ITEN  = ' - Criado Form, Class, DAO e VO da TABELA: ';
    const CREATED_VIEW_ITEN   = ' - Criado Form de Consulta, Class, DAO e VO da VIEW: ';
    const FIELDS_TABLE_VIEW   = ' - Lista de campos da Tabela/View: ';
    
    const GRID_LIST_FK_TITLE  = 'Lista de FK e como elas devem aparecer';
    const GRID_LIST_FK_COLUMN = 'Tipo Campo para FK';
    const GPX_TYPE_CONFIG     = 'Opções de Avançada';
    const GPX_TYPE_SYSTEM     = 'Tipo de sistema';
    const FIELD_TP_SYSTEM     = 'Qual tipo de sistema deseja gerar ?';
    const FIELD_LOGFILE_LABEL = 'Qual tipo de Log em arquivo (php_error.log) quer para o sistema?';
    const FIELD_LOGFILE_OPT00  = 'Nada será gravado no Log !!';
    const FIELD_LOGFILE_OPT01  = 'Quero tudo mesmo! até DomainException !';
    const FIELD_LOGFILE_OPT02  = 'Calma ! Quero log, SEM o DomainException!';
    
    const GEN04_TITLE        = 'Etapa 04 de '.self::LAST_STEP;
    
    const BUTTON_LABEL_BACK  = 'Voltar';
    const BUTTON_LABEL_CLEAN = 'Limpar';    
    const BUTTON_LABEL_CONF  = 'Gerar Config';
    
    const GEN03_BTN_NEXT4_LABEL = 'Seguir Etapa 04 ->';
    const GEN03_BTN_NEXT4_ACT   = 'next4';


    const ERRO_LIST_TABLE_EMPTY     = 'List of Tables Names is empty';
    const ERRO_LIST_TABLE_NOT_ARRAY = 'List of Tables Names not is array';

    const ERRO_LIST_COLUMNS_EMPTY     = 'List of Columns Properties is empty';
    const ERRO_LIST_COLUMNS_NOT_ARRAY = 'List of Columns Properties not is a array';
}
