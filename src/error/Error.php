<?php
namespace Error;

require_once(__DIR__."/../Config.php");

class Error
{
    public static function ReportException(\Exception $e): void
    {
        $cfg = new \Config();
        $db = $cfg->getDatabaseString()['database'];
        $conn = null;
        $newGuid = "";

        try {
            $conn = mysqli_connect($db['host'], $db['username'], $db['password'], $db['dbname']);
            $stmt = mysqli_prepare($conn, "INSERT INTO error (id, file, line, message, created_at, updated_at) VALUES (?,?,?,?,now(),now())");
            $guid = \com_create_guid();
            for ($i = 1; $i < strlen($guid)-1; $i++) {
                $newGuid .= $guid[$i];
            }

            try {
                $file = $e->getFile();
                $line = $e->getLine();
                $message = $e->getMessage();
                $stmt->bind_param("ssis", $newGuid, $file, $line, $message);
                $stmt->execute();
            } finally {
                $stmt->close();
            }
        } finally {
            if ($conn!= null) {
                mysqli_close($conn);
                $conn = null;
            }
        }

        header("Location: ".$_SERVER['CONTEXT_PREFIX']."/error/error.php?id=".$newGuid);
    }
}
