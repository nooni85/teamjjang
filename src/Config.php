<?php

class Config
{
    public function getDatabaseString(): array
    {
        $fp = null;
        $json = null;

        try
        {
            $fp = fopen($_SERVER['CONTEXT_DOCUMENT_ROOT']."/config/global.json", "r");
            $text = "";

            while(!feof($fp))
            {
                $text .= fgets($fp);
            }

            $json = json_decode($text, true);

        } finally {
            if($fp != null)
            {
                fclose($fp);
            }
        }

        return $json;
    }

}
