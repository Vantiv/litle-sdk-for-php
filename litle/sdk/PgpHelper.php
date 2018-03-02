<?php

namespace litle\sdk;

class PgpHelper
{
    /*
     * Encrypt input file using "gpg" with the given public key
     */
    public static function encrypt($encryptInput, $encryptOutput, $publicKey){
        $command = "gpg --batch --yes --quiet --no-secmem-warning --armor --output " .$encryptOutput.
            " --recipient ".$publicKey.
            " --trust-model always --encrypt ".$encryptInput." 2>&1";

        exec($command, $output, $result);
        if($result != 0){
            $response = "";
            foreach ($output as $line){
                $response .= $line . "\n";
            }
            throw new \RuntimeException ("The batch file could not be encrypted. Check the public key entered. ".$response);
        }
    }

    /*
     * Decrypt input file using "gpg" with the given passphrase
     */
    public static function decrypt($decryptInput, $decryptOutput, $passphrase){
        $command = "gpg --batch --yes --quiet --no-secmem-warning --no-mdc-warning  --output ".$decryptOutput.
            " --passphrase ".$passphrase.
            " --decrypt ".$decryptInput." 2>&1";

        exec($command, $output, $result);
        if($result != 0){
            $response = "";
            foreach ($output as $line){
                $response .= $line . "\n";
            }
            throw new \RuntimeException ("The response could not be decrypted. ".$response);
        }
    }

    /*
     * Import input key file into "gpg" keyring
     */
    public static function importKey($keyFile){
        $command = "gpg --import ".$keyFile. " 2>&1";
        exec($command, $output, $result);
        if($result != 0){
            $response = "";
            foreach ($output as $line){
                $response .= $line . "\n";
            }
            throw new \RuntimeException ("The key could not be imported. ".$response);
        }
        $split = explode(" ", $output[0]);
        return rtrim($split[2], ":");
    }
}
