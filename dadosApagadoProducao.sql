-- Deletado dia 16/08/2018 cadastro repetido
DELETE FROM `fpr_sanepar`.`cad_telefone` WHERE `tel_id`='167';
DELETE FROM `fpr_sanepar`.`cad_telefone` WHERE `tel_id`='168';
DELETE FROM `fpr_sanepar`.`cad_telefone` WHERE `tel_id`='169';
DELETE FROM `fpr_sanepar`.`cad_telefone` WHERE `tel_id`='170';
DELETE FROM `fpr_sanepar`.`cad_telefone` WHERE `tel_id`='172';

DELETE FROM `fpr_sanepar`.`cad_contato_status` WHERE `ccs_id`='350';
DELETE FROM `fpr_sanepar`.`cad_contato_status` WHERE `ccs_id`='335';

UPDATE `fpr_sanepar`.`cad_contato_status` SET `ccs_ddr_id`='175' WHERE `ccs_id`='48';
UPDATE `fpr_sanepar`.`cad_contato_status` SET `ccs_ddr_id`='175' WHERE `ccs_id`='336';
UPDATE `fpr_sanepar`.`cad_contato_status` SET `ccs_ddr_id`='175' WHERE `ccs_id`='344';

DELETE FROM `fpr_sanepar`.`cad_doacao` WHERE `doa_id`='163';

DELETE FROM `fpr_sanepar`.`cad_doador` WHERE `ddr_id`='174';
DELETE FROM `fpr_sanepar`.`cad_doador` WHERE `ddr_id`='176';
