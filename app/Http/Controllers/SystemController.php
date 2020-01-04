<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;



class SystemController extends Controller

{



    public function crypt( $string, $action = null )

    {

        // you may change these values to your own

        $secret_key = 'my_simple_secret_key';

        $secret_iv = 'my_simple_secret_iv';

         

        $output = false;

        $encrypt_method = "AES-256-CBC";

        $key = hash( 'sha256', $secret_key );

        $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

         

        if( $action == 'e' ) {

            $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );

        }

        else if( $action == 'd' ){

            $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );

        }

         

         return $output;

    }



    public function encrypt($str, $iv, $key) {



      //$key = $this->hex2bin($key);



        $iv = substr($iv.'cnplussystem',0, 16);

        $key = substr($iv.'cnplussystem',0, 16);





      $td = @mcrypt_module_open('rijndael-128', '', 'cbc', $iv);



      @mcrypt_generic_init($td, $key, $iv);

      $encrypted = @mcrypt_generic($td, $str);



      @mcrypt_generic_deinit($td);

      @mcrypt_module_close($td);



      return bin2hex($encrypted);

    }



    public function decrypt($code, $iv, $key) {

      //$key = $this->hex2bin($key);

      $code = $this->hex2bin($code);



        $iv = substr($iv.'cnplussystem',0, 16);

        $key = substr($iv.'cnplussystem',0, 16);



      $td = @mcrypt_module_open('rijndael-128', '', 'cbc', $iv);



      @mcrypt_generic_init($td, $key, $iv);

      $decrypted = @mdecrypt_generic($td, $code);



      @mcrypt_generic_deinit($td);

      @mcrypt_module_close($td);



      return utf8_encode(trim($decrypted));

    }



    protected function hex2bin($hexdata) {

      $bindata = '';



      for ($i = 0; $i < strlen($hexdata); $i += 2) {

            $bindata .= chr(hexdec(substr($hexdata, $i, 2)));

      }



      return $bindata;

    }



    public function randPassword()

    {

        $alphabet = "abcdefghijklmnopqrstuwxyz0123456789";

        $pass = array();

        $alphaLength = strlen($alphabet) - 1;

        for ($i = 0; $i < 5; $i++) {

            $n = rand(0, $alphaLength);

            $pass[] = $alphabet[$n];

        }

        $password =  implode($pass);



        return $password;

    }

}

