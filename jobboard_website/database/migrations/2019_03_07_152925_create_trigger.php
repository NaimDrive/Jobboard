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
    }
}
