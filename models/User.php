<?php

namespace app\models;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;

    public function init()
    {

        parent::init();
    }

    private static $users = [];


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return new static([
            'id' => '100',
            'username' => $_ENV['ADMIN_USERNAME'],
            'password' => $_ENV['ADMIN_PASSWORD'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }


    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $_ENV['ADMIN_AUTH_KEY'];
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     * @throws \yii\base\Exception
     */
    public function validatePassword($password): bool
    {
        $hash = \Yii::$app->security->generatePasswordHash($password);

        return \Yii::$app->security->validatePassword($password, $hash);
    }
}
