<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $procedures = "CREATE DEFINER=`root`@`localhost` TRIGGER adminlte.persons_BEFORE_INSERT 
            BEFORE INSERT ON adminlte.persons
            FOR EACH ROW
            BEGIN
                SET NEW.created_at = UTC_TIMESTAMP();
                SET NEW.updated_at = UTC_TIMESTAMP();
                SET NEW.uuid = UUID();
                SET NEW.checksum = md5(concat(NEW.name, NEW.status));
            END;";
        //
        $procedures .= "CREATE DEFINER=`root`@`localhost` TRIGGER adminlte.persons_AFTER_INSERT 
            AFTER INSERT ON adminlte.persons
            FOR EACH ROW
            BEGIN
                IF @disable_trigger IS NULL OR @disable_trigger = 0 THEN
                    INSERT INTO persons_log SELECT NULL, UTC_TIMESTAMP(), 1, c.* FROM persons c WHERE c.id = NEW.id;
                END IF;
            END;";

        // Frissítés után
        $procedures .= "CREATE DEFINER=`root`@`localhost` TRIGGER adminlte.persons_AFTER_UPDATE 
            AFTER UPDATE ON adminlte.persons
            FOR EACH ROW
            BEGIN
                IF @disable_trigger IS NULL OR @disable_trigger = 0 THEN
                    set @mod_op = 2;
                    # ha törölték a rekordot, akkor ...
                    IF OLD.status = 1 AND NEW.status = 0 THEN
                        # A módosítási opciót 3-ra (SD soft delete) állítom
                        set @mod_op = 3;
                        # ha visszaállították a rekordot, akkor 4-re (R restore) állítom
                        ELSEIF OLD.status = 0 AND NEW.status = 1 THEN
                        # A módosítási opciót 4-re (R restore) állítom
                        set @mod_op = 4;
                    END IF;
                
                    SET @new_checksum = MD5(CONCAT(NEW.name, NEW.status));
                
                    IF ( OLD.checksum <> @new_checksum ) THEN
                        INSERT INTO persons_log SELECT NULL, UTC_TIMESTAMP(), @mod_op, c.* FROM persons c WHERE c.id = NEW.id;
                    END IF;
                
                END IF;
            END;";

        // Frissítés előtt
        $procedures .= "CREATE DEFINER=`root`@`localhost` TRIGGER adminlte.persons_BEFORE_UPDATE
            BEFORE UPDATE ON adminlte.persons
            FOR EACH ROW
            BEGIN
            
                IF ( OLD.status <> NEW.status ) THEN
                    SET NEW.status_changed_at = UTC_TIMESTAMP();
                    
                    IF OLD.status = 1 AND NEW.status = 0 THEN
                        SET NEW.deleted_at = UTC_TIMESTAMP();
                    ELSEIF OLD.status = 0 AND NEW.status = 1 THEN
                        SET NEW.deleted_at = NULL;
                    END IF;
                END IF;
                
                SET @new_checksum = MD5(CONCAT(NEW.name, NEW.status));
                
                IF ( OLD.checksum <> @new_checksum ) THEN
                    SET NEW.updated_at = UTC_TIMESTAMP();
                    SET NEW.checksum = @new_checksum;
                END IF;
            
            END;";

        // Törlés előtt
        $procedures .= "CREATE DEFINER=`root`@`localhost` TRIGGER adminlte.persons_BEFORE_DELETE 
            BEFORE DELETE ON adminlte.persons
            FOR EACH ROW
            BEGIN
                IF @disable_trigger IS NULL OR @disable_trigger = 0 THEN
                    INSERT INTO persons_log SELECT NULL, UTC_TIMESTAMP(), 5, c.* FROM persons c WHERE c.id = OLD.id;
                END IF;
            END;";

        DB::unprepared($procedures);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $procedures = "DROP TRIGGER IF EXISTS adminlte.persons_BEFORE_INSERT;";
        $procedures .= "DROP TRIGGER IF EXISTS adminlte.persons_AFTER_INSERT;";
        $procedures .= "DROP TRIGGER IF EXISTS adminlte.persons_AFTER_UPDATE;";
        $procedures .= "DROP TRIGGER IF EXISTS adminlte.persons_BEFORE_UPDATE;";
        $procedures .= "DROP FRIGGER IF EXISTS adminlte.persons_BEFORE_DELETE;";

        DB::unprepared($procedures);
    }
};
