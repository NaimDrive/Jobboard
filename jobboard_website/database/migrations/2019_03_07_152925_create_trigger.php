<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER trigger_update_adresses_entreprise AFTER UPDATE on `entreprise` FOR EACH ROW
        BEGIN
            DELETE FROM `adress_entreprise` WHERE `idEntreprise` = NEW.id;
        END
        ');
        DB::unprepared('
        CREATE TRIGGER trigger_update_contacts_entreprise AFTER UPDATE on `entreprise` FOR EACH ROW
        BEGIN
            DELETE FROM `contact_entreprise` WHERE `idEntreprise` = NEW.id AND idUser IS NULL;
        END
        ');
        DB::unprepared('
        CREATE TRIGGER trigger_update_entreprise_inactif AFTER UPDATE on `entreprise` FOR EACH ROW
        BEGIN
            UPDATE contact_entreprise SET actif = NEW.actif WHERE idEntreprise = NEW.id;
            DELETE FROM offre WHERE idEntreprise = NEW.id;
        END
        ');
        DB::unprepared('
        CREATE TRIGGER trigger_delete_entreprise_participe AFTER DELETE on `entreprise_participes` FOR EACH ROW
        BEGIN
            DELETE FROM `contact_participes` WHERE `idEntrepriseParticipe` = OLD.id;
        END
        ');
        DB::unprepared('
        CREATE TRIGGER trigger_delete_forum AFTER DELETE on `forums` FOR EACH ROW
        BEGIN
            DELETE FROM `entreprise_participes` WHERE `idForum` = OLD.id;
        END
        ');
        DB::unprepared('
        CREATE TRIGGER trigger_update_competences_etudiant AFTER UPDATE on `etudiant` FOR EACH ROW
        BEGIN
            DELETE FROM `competences_etudiant` WHERE `idEtudiant` = NEW.id;
        END
        ');
        DB::unprepared('
        CREATE TRIGGER trigger_update_formations_etudiant AFTER UPDATE on `etudiant` FOR EACH ROW
        BEGIN
            DELETE FROM `formation` WHERE `idEtudiant` = NEW.id;
        END
        ');
        DB::unprepared('
        CREATE TRIGGER trigger_update_experiences_etudiant AFTER UPDATE on `etudiant` FOR EACH ROW
        BEGIN
            DELETE FROM `experience` WHERE `idEtudiant` = NEW.id;
        END
        ');
        DB::unprepared('
        CREATE TRIGGER trigger_update_liens_etudiant AFTER UPDATE on `etudiant` FOR EACH ROW
        BEGIN
            DELETE FROM `reference_lien` WHERE `idEtudiant` = NEW.id;
        END
        ');
        DB::unprepared('
        CREATE TRIGGER trigger_update_activites_etudiant AFTER UPDATE on `etudiant` FOR EACH ROW
        BEGIN
            DELETE FROM `centre_d_interet` WHERE `idEtudiant` = NEW.id;
        END
        ');

        DB::unprepared('
        CREATE TRIGGER trigger_incremente_etudiant AFTER INSERT on `etudiant` FOR EACH ROW
        BEGIN
            UPDATE stat SET nbEtu = nbEtu + 1;
        END
        ');
        DB::unprepared('
        CREATE TRIGGER trigger_incremente_entreprise AFTER INSERT on `entreprise` FOR EACH ROW
        BEGIN
            UPDATE stat SET nbEnt = nbEnt + 1;
        END
        ');
        DB::unprepared('
        CREATE TRIGGER trigger_incremente_contact AFTER INSERT on `contact_entreprise` FOR EACH ROW
        BEGIN
            UPDATE stat SET nbCon = nbCon + 1;
        END
        ');
        DB::unprepared('
        CREATE TRIGGER trigger_incremente_offre AFTER INSERT on `offre` FOR EACH ROW
        BEGIN
            UPDATE stat SET nbOff = nbOff + 1;
        END
        ');
        DB::unprepared('
        CREATE TRIGGER trigger_decremente_etudiant AFTER DELETE on `etudiant` FOR EACH ROW
        BEGIN
            UPDATE stat SET nbEtu = nbEtu - 1;
        END
        ');
        DB::unprepared('
        CREATE TRIGGER trigger_decremente_entreprise AFTER DELETE on `entreprise` FOR EACH ROW
        BEGIN
            UPDATE stat SET nbEnt = nbEnt - 1;
        END
        ');
        DB::unprepared('
        CREATE TRIGGER trigger_decremente_contact AFTER DELETE on `contact_entreprise` FOR EACH ROW
        BEGIN
            UPDATE stat SET nbCon = nbCon - 1;
        END
        ');
        DB::unprepared('
        CREATE TRIGGER trigger_decremente_offre AFTER DELETE on `offre` FOR EACH ROW
        BEGIN
            UPDATE stat SET nbOff = nbOff - 1;
        END
        ');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `trigger_update_adresses_entreprise`');
        DB::unprepared('DROP TRIGGER `trigger_update_contacts_entreprise`');
        DB::unprepared('DROP TRIGGER `trigger_update_contact_inactif`');
        DB::unprepared('DROP TRIGGER `trigger_delete_entreprise_participe`');
        DB::unprepared('DROP TRIGGER `trigger_delete_forum`');
        DB::unprepared('DROP TRIGGER `trigger_update_competences`');
        DB::unprepared('DROP TRIGGER `trigger_update_formations`');
        DB::unprepared('DROP TRIGGER `trigger_update_experiences`');
        DB::unprepared('DROP TRIGGER `trigger_update_liens`');
        DB::unprepared('DROP TRIGGER `trigger_update_activites`');
        DB::unprepared('DROP TRIGGER trigger_incremente_etudiant');
        DB::unprepared('DROP TRIGGER trigger_incremente_entreprise');
        DB::unprepared('DROP TRIGGER trigger_incremente_etudiant');
        DB::unprepared('DROP TRIGGER trigger_incremente_contact');
        DB::unprepared('DROP TRIGGER trigger_decremente_etudiant');
        DB::unprepared('DROP TRIGGER trigger_decremente_entreprise');
        DB::unprepared('DROP TRIGGER trigger_decremente_contact');
        DB::unprepared('DROP TRIGGER trigger_decremente_offre');
    }
}
