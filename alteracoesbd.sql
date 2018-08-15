ALTER TABLE `fpr_sanepar`.`cad_doador` 
CHANGE COLUMN `ddr_cidade` `ddr_cidade` VARCHAR(30) NULL DEFAULT NULL AFTER `ddr_cpf`,
ADD COLUMN `ddr_datainclusao` DATE NULL AFTER `ddr_cidade`;

ALTER TABLE fpr_sanepar.cad_pessoas
CHANGE COLUMN pes_nascimento pes_nascimento DATE NULL DEFAULT NULL ;
ALTER TABLE cad_pessoas ADD created_at timestamp NULL DEFAULT NULL;
ALTER TABLE cad_pessoas ADD updated_at timestamp NULL DEFAULT NULL;
/** ver todos as pessoas com data nascimento = 0000-00-00 e atualizar para null **/
