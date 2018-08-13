ALTER TABLE `fpr_sanepar`.`cad_doador` 
CHANGE COLUMN `ddr_cidade` `ddr_cidade` VARCHAR(30) NULL DEFAULT NULL AFTER `ddr_cpf`,
ADD COLUMN `ddr_datainclusao` DATE NULL AFTER `ddr_cidade`;
