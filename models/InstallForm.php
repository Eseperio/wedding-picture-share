<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;

class InstallForm extends Model
{
    public $siteName;
    public $username;
    public $password;
    public $password_repeat;


    public $dbHost = 'localhost';
    public $dbPort = 3306;
    public $dbName;
    public $dbUser;
    public $dbPassword;



    public function rules()
    {
        return [
            [['siteName', 'username', 'password', 'password_repeat'], 'required'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('xenon', 'Passwords do not match.')],
            // enforce password to be at least 8 characters long and contain at least one number
            ['password', 'match', 'pattern' => '/^(?=.*\d)(?=.*[a-zA-Z]).{8,}$/', 'message' => Yii::t('xenon', 'Password must be at least 8 characters long and contain at least one number.')],
            [['siteName', 'username', 'password'], 'filter', 'filter' => function ($value) {
                return strip_tags($value);
            }],
            [['siteName', 'username', 'password'], 'string', 'max' => 255],

            // db validators
            [['dbHost', 'dbPort', 'dbName', 'dbUser', 'dbPassword'], 'required'],
            [['dbHost', 'dbName', 'dbUser', 'dbPassword'], 'string', 'max' => 255],
            [['dbPort'], 'integer'],

            // validate db connection
            [['dbHost', 'dbPort', 'dbName', 'dbUser', 'dbPassword'], 'validateDbConnection'],
        ];
    }

    public function validateDbConnection($attribute, $params)
    {
        if (!$this->hasErrors()) {
            try {
                $dsn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName . ';port=' . $this->dbPort;
                $db = new \yii\db\Connection([
                    'dsn' => $dsn,
                    'username' => $this->dbUser,
                    'password' => $this->dbPassword,
                    'charset' => 'utf8',
                ]);
                $db->open();
            } catch (\Exception $e) {
                $this->addError($attribute, Yii::t('xenon', 'Could not connect to database. Please check your credentials.'));
            }
        }
    }

    public function install()
    {

        try {// Save values to .env file, hashing the password
            $configFile = Yii::getAlias('@app/.env');//if file does not exist, create it from the template
            if (!file_exists($configFile)) {
                copy(Yii::getAlias('@app/.env.dist'), $configFile);
            }

            /**
             * Array with key as variable name and value as variable value to be replaced in .env file
             */
            $params = [
                'ADMIN_USERNAME' => $this->username,
                'ADMIN_PASSWORD' => Yii::$app->security->generatePasswordHash($this->password),
                'ADMIN_AUTH_KEY' => Yii::$app->security->generateRandomString(),

                'APP_NAME' => $this->siteName,

                'MYSQL_DATABASE' => $this->dbName,
                'MYSQL_HOST' => $this->dbHost,
                'MYSQL_PORT' => $this->dbPort,
                'MYSQL_NAME' => $this->dbName,
                'MYSQL_USER' => $this->dbUser,
                'MYSQL_PASSWORD' => $this->dbPassword,



            ];
            $envContent = file_get_contents($configFile);// add the new values by searching for variable name and replacing the value
            foreach ($params as $key => $value) {
                $envContent = preg_replace('/' . $key . '=(.*)/', $key . '=' . $value, $envContent);
            }

            file_put_contents($configFile, $envContent);

            Yii::$app->response->redirect('after-install');

        } catch (Exception $e) {
            @unlink($configFile);
            if (YII_DEBUG) {
                throw $e;
            }
            Yii::$app->session->setFlash('error', Yii::t('xenon', 'Error saving configuration file. Please check file permissions.'));
        }

    }


}
