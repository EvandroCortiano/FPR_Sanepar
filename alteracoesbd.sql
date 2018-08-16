ALTER TABLE `fpr_sanepar`.`cad_doador` 
CHANGE COLUMN `ddr_cidade` `ddr_cidade` VARCHAR(30) NULL DEFAULT NULL AFTER `ddr_cpf`,
ADD COLUMN `ddr_datainclusao` DATE NULL AFTER `ddr_cidade`;

ALTER TABLE fpr_sanepar.cad_pessoas
CHANGE COLUMN pes_nascimento pes_nascimento DATE NULL DEFAULT NULL ;
ALTER TABLE cad_pessoas ADD created_at timestamp NULL DEFAULT NULL;
ALTER TABLE cad_pessoas ADD updated_at timestamp NULL DEFAULT NULL;
/** ver todos as pessoas com data nascimento = 0000-00-00 e atualizar para null **/

ALTER TABLE `fpr_sanepar`.`cad_contato_status` 
CHANGE COLUMN `ccs_id` `ccs_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT FIRST,
CHANGE COLUMN `ccs_pes_id` `ccs_pes_id` INT(11) NULL DEFAULT NULL COMMENT 'Id da pessoa contactada' AFTER `ccs_id`;

ALTER TABLE `fpr_sanepar`.`cad_doador` 
ADD COLUMN `ddr_pes_id` INT NULL DEFAULT NULL AFTER `ddr_datainclusao`,
ADD UNIQUE INDEX `ddr_pes_id_UNIQUE` (`ddr_pes_id` ASC);