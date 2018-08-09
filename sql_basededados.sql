
CREATE TABLE cad_competencia (
                cpa_id INT AUTO_INCREMENT NOT NULL,
                cpa_mes_ref VARCHAR(10) NOT NULL,
                cpa_data_inicio DATE NOT NULL,
                cpa_data_fim DATE NOT NULL,
                cpa_semana_mes VARCHAR(50) DEFAULT NULL,
                PRIMARY KEY (cpa_id)
);

ALTER TABLE cad_competencia COMMENT 'Tabela para inserção da copetencia semanal a ser enviada para sanepar.';


CREATE TABLE cad_doador (
                ddr_id INT AUTO_INCREMENT NOT NULL,
                ddr_nome VARCHAR(200) NOT NULL,
                ddr_matricula VARCHAR(30),
                ddr_telefone_principal VARCHAR(20),
                PRIMARY KEY (ddr_id)
);

ALTER TABLE cad_doador COMMENT 'Cadastro do doador.';


CREATE TABLE cad_doacao (
                doa_id INT AUTO_INCREMENT NOT NULL,
                doa_ddr_id INT NOT NULL,
                doa_data DATE NOT NULL,
                doa_data_final DATE,
                doa_valor VARCHAR(20) NOT NULL,
                doa_qtde_parcela INT NOT NULL,
                doa_motivo VARCHAR(50),
                doa_valor_mensal VARCHAR(15) NOT NULL,
                PRIMARY KEY (doa_id)
);

ALTER TABLE cad_doacao COMMENT 'Tabela com os dados da doacao para a fundacao.';


CREATE TABLE cad_repasse (
                cre_id INT AUTO_INCREMENT NOT NULL,
                cre_doa_id INT NOT NULL,
                cre_cpa_id INT NOT NULL,
                cre_parcela INT NOT NULL,
                PRIMARY KEY (cre_id)
);

ALTER TABLE cad_repasse COMMENT 'Tabela com os dados de repasse.';


CREATE TABLE san_retorno (
                rto_id INT AUTO_INCREMENT NOT NULL,
                rto_cre_id INT NOT NULL,
                rto_ddr_id INT NOT NULL,
                rto_status VARCHAR(70) NOT NULL,
                rto_data_credito VARCHAR(15),
                rto_valor_credito VARCHAR(15),
                PRIMARY KEY (rto_id)
);

ALTER TABLE san_retorno COMMENT 'Tabela salva atraves do arquivo de retorno da sanepar.';


ALTER TABLE cad_repasse ADD CONSTRAINT cad_competencia_cad_repasse_fk
FOREIGN KEY (cre_cpa_id)
REFERENCES cad_competencia (cpa_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE cad_doacao ADD CONSTRAINT cad_doador_cad_doacao_fk
FOREIGN KEY (doa_ddr_id)
REFERENCES cad_doador (ddr_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE san_retorno ADD CONSTRAINT cad_doador_san_retorno_fk
FOREIGN KEY (rto_ddr_id)
REFERENCES cad_doador (ddr_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE cad_repasse ADD CONSTRAINT cad_doacao_cad_repasse_fk
FOREIGN KEY (cre_doa_id)
REFERENCES cad_doacao (doa_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE san_retorno ADD CONSTRAINT cad_repasse_san_retorno_fk
FOREIGN KEY (rto_cre_id)
REFERENCES cad_repasse (cre_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE cad_doador ADD created_at timestamp NULL DEFAULT NULL;
ALTER TABLE cad_doador ADD updated_at timestamp NULL DEFAULT NULL;

ALTER TABLE cad_competencia ADD created_at timestamp NULL DEFAULT NULL;
ALTER TABLE cad_competencia ADD updated_at timestamp NULL DEFAULT NULL;

ALTER TABLE cad_doacao ADD created_at timestamp NULL DEFAULT NULL;
ALTER TABLE cad_doacao ADD updated_at timestamp NULL DEFAULT NULL;

ALTER TABLE cad_repasse ADD created_at timestamp NULL DEFAULT NULL;
ALTER TABLE cad_repasse ADD updated_at timestamp NULL DEFAULT NULL;

ALTER TABLE san_retorno ADD created_at timestamp NULL DEFAULT NULL;
ALTER TABLE san_retorno ADD updated_at timestamp NULL DEFAULT NULL;


CREATE TABLE IF NOT EXISTS tab_status_motivo (
  `smt_id` INT UNSIGNED NOT NULL,
  `smt_nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`smt_id`))
ENGINE = InnoDB
COMMENT = 'Tabela com os motivos para o cadastro da doacao.';
ALTER TABLE tab_status_motivo 
CHANGE COLUMN `smt_id` `smt_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ;

ALTER TABLE cad_doacao ADD doa_smt_id INT UNSIGNED NULL after doa_valor_mensal;

ALTER TABLE cad_doacao
ADD CONSTRAINT fk_cad_doacao_1
  FOREIGN KEY (doa_smt_id)
  REFERENCES tab_status_motivo(smt_id)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
CREATE TABLE IF NOT EXISTS `sanepar_fpr`.`tab_status_contato` (
  `stc_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `stc_nome` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`stc_id`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `sanepar_fpr`.`cad_contato_status` (
  `ccs_scd_id` INT NOT NULL,
  `ccs_ddr_id` INT(11) NOT NULL,
  `ccs_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ccs_obs` MEDIUMTEXT NULL,
  `css_stc_id` INT UNSIGNED NOT NULL,
  INDEX `fk_tab_status_contatoddr_has_cad_doador_cad_doador1_idx` (`ccs_ddr_id` ASC),
  PRIMARY KEY (`ccs_id`),
  INDEX `fk_cad_contato_status_tab_status_contato1_idx` (`css_stc_id` ASC),
  CONSTRAINT `fk_tab_status_contatoddr_has_cad_doador_cad_doador1`
    FOREIGN KEY (`ccs_ddr_id`)
    REFERENCES `sanepar_fpr`.`cad_doador` (`ddr_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cad_contato_status_tab_status_contato1`
    FOREIGN KEY (`css_stc_id`)
    REFERENCES `sanepar_fpr`.`tab_status_contato` (`stc_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
  
CREATE TABLE IF NOT EXISTS `sanepar_fpr`.`cad_pessoas` (
  `pes_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `pes_nome` VARCHAR(120) NULL,
  `pes_cpf` VARCHAR(15) NULL,
  `pes_sexo` VARCHAR(15) NULL,
  `pes_nascimento` DATE NULL,
  `pes_mae` VARCHAR(100) NULL,
  `pes_endereco` VARCHAR(80) NULL,
  `pes_numero` VARCHAR(5) NULL,
  `pes_complemento` VARCHAR(40) NULL,
  `pes_bairro` VARCHAR(45) NULL,
  `pes_cidade` VARCHAR(60) NULL,
  `pes_estado` VARCHAR(2) NULL,
  `pes_cep` VARCHAR(10) NULL,
  `pes_tel1` VARCHAR(15) NULL,
  `pes_tel2` VARCHAR(15) NULL,
  `pes_tel3` VARCHAR(15) NULL,
  `pes_tel4` VARCHAR(15) NULL,
  `pes_tel5` VARCHAR(15) NULL,
  `pes_email` VARCHAR(60) NULL,
  PRIMARY KEY (`pes_id`))
ENGINE = InnoDB
COMMENT = 'Tabela com os posiveis doadores';


ALTER TABLE `cad_doador` 
ADD COLUMN `ddr_titular_conta` VARCHAR(120) NULL DEFAULT NULL AFTER `ddr_telefone_principal`,
ADD COLUMN `ddr_endereco` VARCHAR(80) NULL DEFAULT NULL AFTER `ddr_titular_conta`,
ADD COLUMN `ddr_numero` VARCHAR(5) NULL DEFAULT NULL AFTER `ddr_endereco`,
ADD COLUMN `ddr_complemento` VARCHAR(45) NULL DEFAULT NULL AFTER `ddr_numero`,
ADD COLUMN `ddr_bairro` VARCHAR(60) NULL DEFAULT NULL AFTER `ddr_complemento`,
ADD COLUMN `ddr_cid_id` INT NULL DEFAULT NULL AFTER `ddr_bairro`,
ADD COLUMN `ddr_cep` VARCHAR(10) NULL DEFAULT NULL AFTER `ddr_cid_id`,
ADD COLUMN `ddr_nascimento` DATE NULL DEFAULT NULL AFTER `ddr_cep`,
ADD COLUMN `ddr_cpf` VARCHAR(15) NULL DEFAULT NULL AFTER `ddr_nascimento`,
CHANGE COLUMN `updated_at` `updated_at` TIMESTAMP NULL DEFAULT NULL AFTER `ddr_cpf`;

CREATE TABLE IF NOT EXISTS `cad_telefone` (
  `tel_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tel_numero` VARCHAR(20) NOT NULL,
  `tel_obs` VARCHAR(100) NULL,
  PRIMARY KEY (`tel_id`))
ENGINE = InnoDB
COMMENT = 'Telefones dos doadores.';