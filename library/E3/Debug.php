<?
require_once 'Zend/Debug.php';
class E3_Debug extends Zend_Debug {
    /**
     * Debug helper function.  This is a wrapper for var_dump() that adds
     * the <pre /> tags, cleans up newlines and indents, and runs
     * htmlentities() before output.
     *
     * @param  mixed  $var   The variable to dump.
     * @param  string $label OPTIONAL Label to prepend to output.
     * @param  bool   $echo  OPTIONAL Echo output if true.
     * @return string
     */
    public static function dump($var, $label=null, $echo=true, $console=true)
    {
        // format the label
        $label = ($label===null) ? '' : rtrim($label) . ' ';

        // var_dump the variable into a buffer and keep the output
        ob_start();
        var_dump($var);
        $output = ob_get_clean();

        // neaten the newlines and indents
        $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
        if (self::getSapi() == 'cli') {
            $output = PHP_EOL . $label
                    . PHP_EOL . $output
                    . PHP_EOL;
        } else {
            if(!$console) {
                $output = '<pre>'
                        . $label
                        . htmlspecialchars($output, ENT_QUOTES)
                        . '</pre>';
            } else {
                $output = $label.$output;
            }
        }

        if(preg_match("/Zend_Db_Statement_Exception/", $output)) {
            preg_match("/\[\"message\:protected\"\]\s+\=\>\s+string\(\d+\)\s+\"(.*)\"\n/", $output, $p);
            $msg = '';
            if(!empty($p)) $msg = $p[1];
            preg_match("/(insert|update|delete|select[^\"]*)\"/i", $output, $p);
            $sql = '';
            if(!empty($p)) $sql = $p[1];
            $output = $output
                    . PHP_EOL
                    . "***** Error message *****"
                    . PHP_EOL
                    . $msg
                    . PHP_EOL
                    . PHP_EOL
                    . "******* Error SQL *******"
                    . PHP_EOL
                    . $sql
                    . PHP_EOL;
        }

        if ($echo) {
            echo($output);
        }
        return $output;
    }
}