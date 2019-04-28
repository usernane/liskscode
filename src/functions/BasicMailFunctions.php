<?php
/*
 * The MIT License
 *
 * Copyright 2019 Ibrahim, WebFiori Framework.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
namespace webfiori\functions;
if(!defined('ROOT_DIR')){
    header("HTTP/1.1 403 Forbidden");
    die(''
        . '<!DOCTYPE html>'
        . '<html>'
        . '<head>'
        . '<title>Forbidden</title>'
        . '</head>'
        . '<body>'
        . '<h1>403 - Forbidden</h1>'
        . '<hr>'
        . '<p>'
        . 'Direct access not allowed.'
        . '</p>'
        . '</body>'
        . '</html>');
}
use webfiori\entity\Logger;
use webfiori\entity\FileHandler;
use webfiori\entity\mail\SMTPAccount;
use webfiori\entity\mail\SocketMailer;
/**
 * A class for the methods that is related to mailing.
 *
 * @author Ibrahim
 * @version 1.3
 */
class BasicMailFunctions extends Functions{
    /**
     * A constant that indicates a mail server address or its port 
     * is invalid.
     * @since 1.1
     */
    const INV_HOST_OR_PORT = 'inv_mail_host_or_port';
    /**
     * A constant that indicates the given username or password  
     * is invalid.
     * @since 1.1
     */
    const INV_CREDENTIALS = 'inv_username_or_pass';
    /**
     *
     * @var MailFunctions 
     * @since 1.0
     */
    private static $instance;
    /**
     * Returns a singleton of the class.
     * @return BasicMailFunctions
     * @since 1.0
     */
    public static function &get(){
        Logger::logFuncCall(__METHOD__);
        if(self::$instance === null){
            Logger::log('Initializing \'BasicMailFunctions\' instance...');
            self::$instance = new BasicMailFunctions();
            Logger::log('Initializing of \'BasicMailFunctions\' completed.');
        }
        Logger::log('Returning \'BasicMailFunctions\' instance.');
        Logger::logFuncReturn(__METHOD__);
        return self::$instance;
    }
    public function __construct() {
        parent::__construct();
    }
    /**
     * Creates the file 'MailConfig.php' if it does not exist.
     * @since 1.0
     */
    public function createEmailConfigFile(){
        Logger::logFuncCall(__METHOD__);
        if(!class_exists('webfiori\conf\MailConfig')){
            Logger::log('Creating Configuration File \'MailConfig.php\'');
            $this->writeMailConfig(array());
            Logger::log('Creatied.');
        }
        else{
            Logger::log('Configuration File \'MailConfig.php\' Already Exist.');
        }
        Logger::logFuncReturn(__METHOD__);
    }
    /**
     * A method to save changes to mail configuration file.
     * @param type $emailAccountsArr An array that contains an objects of 
     * type 'EmailAccount'. 
     * @since 1.1
     */
    private function writeMailConfig($emailAccountsArr){
        Logger::logFuncCall(__METHOD__);
        $fh = new FileHandler(ROOT_DIR.'/conf/MailConfig.php');
        $fh->write('<?php', true, true);
        $fh->write('/*
 * The MIT License
 *
 * Copyright 2019 Ibrahim, WebFiori Framework.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
 
');
        $fh->write('namespace webfiori\conf;', true, true);
        $fh->write('if(!defined(\'ROOT_DIR\')){
    header("HTTP/1.1 403 Forbidden");
    die(\'\'
        . \'<!DOCTYPE html>\'
        . \'<html>\'
        . \'<head>\'
        . \'<title>Forbidden</title>\'
        . \'</head>\'
        . \'<body>\'
        . \'<h1>403 - Forbidden</h1>\'
        . \'<hr>\'
        . \'<p>\'
        . \'Direct access not allowed.\'
        . \'</p>\'
        . \'</body>\'
        . \'</html>\');
}', true, true);
        $fh->write('use webfiori\entity\mail\SMTPAccount;', true, true);
        $fh->write('/**
 * SMTP configuration class.
 * The developer can create multiple SMTP accounts and add 
 * Connection information inside the body of this class.
 * @author Ibrahim
 * @version 1.0
 */', true, true);
        $fh->write('class MailConfig{', true, true);
        $fh->addTab();
        //stat here
        $fh->write('private $emailAccounts;
    /**
     *
     * @var MailConfig 
     * @since 1.0
     */
    private static $inst;
    /**
     * Return a single instance of the class.
     * Calling this method multiple times will result in returning 
     * the same instance every time.
     * @return MailConfig
     * @since 1.0
     */
    public static function &get(){
        if(self::$inst === null){
            self::$inst = new MailConfig();
        }
        return self::$inst;
    }', true, true);
        $fh->write('private function __construct() {', true, true);
        $fh->addTab();
        $fh->reduceTab();
        //adding email accounts
        $index=0;
        foreach ($emailAccountsArr as $emailAcc){
            $fh->write('$acc'.$index.' = new SMTPAccount();
        $acc'.$index.'->setServerAddress(\''.$emailAcc->getServerAddress().'\');
        $acc'.$index.'->setAddress(\''.$emailAcc->getAddress().'\');
        $acc'.$index.'->setUsername(\''.$emailAcc->getUsername().'\');
        $acc'.$index.'->setPassword(\''.$emailAcc->getPassword().'\');
        $acc'.$index.'->setName(\''.$emailAcc->getName().'\');
        $acc'.$index.'->setPort('.$emailAcc->getPort().');
        $this->addAccount($acc'.$index.', \'no-replay\');',true,true);
            $index++;
        }
        $fh->write('}', true, true);
        $fh->reduceTab();
        $fh->write('/**
     * Adds an email account.
     * The developer can use this method to add new account during runtime. 
     * The account will be removed once the program finishes.
     * @param EmailAccount $acc an object of type EmailAccount.
     * @param string $name A name to associate with the email account.
     * @since 1.0
     */
    private function addAccount($acc,$name){
        $this->emailAccounts[$name] = $acc;
    }
    private function &_getAccount($name){
        if(isset($this->emailAccounts[$name])){
            return $this->emailAccounts[$name];
        }
        $null = null;
        return $null;
    }
    /**
     * Returns an email account given its name.
     * The method will search for an account with the given name in the set 
     * of added accounts. If no account was found, null is returned.
     * @param string $name The name of the account.
     * @return EmailAccount|null If the account is found, The method 
     * will return an object of type EmailAccount. Else, the 
     * method will return null.
     * @since 1.0
     */
    public static function &getAccount($name){
        return self::get()->_getAccount($name);
    }
    private function _getAccounts(){
        return $this->emailAccounts;
    }
    /**
     * Returns an associative array that contains all email accounts.
     * The indices of the array will act as the names of the accounts. 
     * The value of the index will be an object of type EmailAccount.
     * @return array An associative array that contains all email accounts.
     * @since 1.0
     */
    public static function getAccounts(){
        return self::get()->_getAccounts();
    }', true, true);
        $fh->write('}', true, true);
        $fh->close();
        Logger::logFuncReturn(__METHOD__);
    }
    /**
     * Removes SMTP email account if it is exist.
     * @param string $accountName The name of the email account (such as 'no-replay').
     * @return boolean If the account is not exist or the class 'MailConfig' 
     * does not exist, the method will return false. If the account was removed, 
     * The method will return true.
     * @since 1.3
     */
    public function removeAccount($accountName) {
        Logger::logFuncCall(__METHOD__);
        $retVal = false;
        if(class_exists('webfiori\conf\MailConfig')){
            $account = &MailConfig::getAccount($accountName);
            if($account instanceof SMTPAccount){
                $accountsArr = MailConfig::getAccounts();
                unset($accountsArr[$accountName]);
                $toSave = array();
                foreach ($accountsArr as $account){
                    $toSave[] = $account;
                }
                $this->writeMailConfig($toSave);
                $retVal = true;
            }
        }
        Logger::logReturnValue($retVal);
        Logger::logFuncReturn(__METHOD__);
        return $retVal;
    }
    /**
     * Adds new SMTP account or Updates an existing one.
     * @param SMTPAccount $emailAccount An instance of 'EmailAccount'.
     * @return boolean|string The method will return true if the email 
     * account was updated or added. If the email account contains wrong server
     *  information, the method will return MailFunctions::INV_HOST_OR_PORT. 
     * If the given email account contains wrong login info, the method will 
     * return MailFunctions::INV_CREDENTIALS. Other than that, the method 
     * will return false.
     * @since 1.1
     */
    public function updateOrAddEmailAccount($emailAccount) {
        Logger::logFuncCall(__METHOD__);
        $retVal = false;
        if($emailAccount instanceof SMTPAccount){
            $sm = $this->getSocketMailer($emailAccount);
            if($sm instanceof SocketMailer){
                if(class_exists('webfiori\conf\MailConfig')){
                    $accountsArr = MailConfig::getAccounts();
                    $accountsArr[$emailAccount->getName()] = $emailAccount;
                    $toSave = array();
                    foreach ($accountsArr as $account){
                        $toSave[] = $account;
                    }
                    $this->writeMailConfig($toSave);
                }
                else{
                    $arr = array($emailAccount);
                    $this->writeMailConfig($arr);
                }
                $retVal = true;
            }
            $retVal = $sm;
        }
        Logger::logReturnValue($retVal);
        Logger::logFuncReturn(__METHOD__);
        return $retVal;
    }
    /**
     * Returns a new instance of the class SocketMailer.
     * The method will try to establish a connection to SMTP server using 
     * the given SMTP account.
     * @param SMTPAccount $emailAcc An account that is used to initiate 
     * socket mailer.
     * @return SocketMailer|string The method will return an instance of SocketMailer
     * on successful connection. If no connection is established, the method will 
     * return MailFunctions::INV_HOST_OR_PORT. If user authentication fails, 
     * the method will return 'MailFunctions::INV_CREDENTIALS'.
     * @since 1.0
     */
    public function getSocketMailer($emailAcc){
        Logger::logFuncCall(__METHOD__);
        if($emailAcc instanceof SMTPAccount){
            $retVal = BasicMailFunctions::INV_HOST_OR_PORT;
            Logger::log('Creating new instance of \'SocketMailer\' using given email account.');
            Logger::log('Server Address: \''.$emailAcc->getServerAddress().'\'', 'debug');
            Logger::log('Port: \''.$emailAcc->getPort().'\'', 'debug');
            Logger::log('Username: \''.$emailAcc->getUsername().'\'', 'debug');
            Logger::log('Password: \''.$emailAcc->getPassword().'\'', 'debug');
            Logger::log('Email Address: \''.$emailAcc->getAddress().'\'', 'debug');
            Logger::log('Account Name: \''.$emailAcc->getName().'\'', 'debug');
//            Logger::log('Using TLS = \''.$emailAcc->isTLS().'\'.','debug');
//            Logger::log('Using SSL = \''.$emailAcc->isSSL().'\'.','debug');
            $m = new SocketMailer();
            //$m->isSSL($emailAcc->isSSL());
            //$m->isTLS($emailAcc->isTLS());
            $m->setHost($emailAcc->getServerAddress());
            $m->setPort($emailAcc->getPort());
            Logger::log('Testing connection...');
            if($m->connect()){
                Logger::log('Connected to email server.');
                Logger::log('Validating credentials...');
                $m->setSender($emailAcc->getName(), $emailAcc->getAddress());
                if($m->login($emailAcc->getUsername(), $emailAcc->getPassword())){
                    Logger::log('Logged in to the email server.');
                    $retVal = $m;
                }
                else{
                    Logger::log('Unable to login.','warning');
                    $retVal = BasicMailFunctions::INV_CREDENTIALS;
                }
            }
            Logger::logFuncReturn(__METHOD__);
            return $retVal;
        }
        Logger::log('The given parameter is not an instance of \'SMTPAccount\'.', 'warning');
        Logger::logFuncReturn(__METHOD__);
        return false;
    }
}