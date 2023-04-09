<?php

namespace app\models;

use Yii;
use yii\helpers\Html;

const _MAX_FILE_SIZE = 26214400;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $photo
 * @property int $currency_id
 * @property int $price
 * @property int $user_creator_id
 * @property int $count
 * @property int $status_id
 *
 * @property Currency $currency
 * @property ProductUser[] $productUsers
 * @property StatusProduct $status
 * @property User $userCreator
 */
class Product extends \yii\db\ActiveRecord
{
    public $photosFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'currency_id', 'price', 'user_creator_id', 'status_id'], 'required'],
            [['currency_id', 'price', 'user_creator_id', 'count', 'status_id'], 'integer'],
            [['name', 'description', 'photo'], 'string', 'max' => 1000],
            [['photosFile'], 'file', 'extensions' => 'jpg, jpeg, png, pdf, doc, docx, zip, rar, 7z, tag', 'skipOnEmpty' => true, 'maxSize' => 26214400, 'maxFiles' => 10],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::class, 'targetAttribute' => ['currency_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusProduct::class, 'targetAttribute' => ['status_id' => 'id']],
            [['user_creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_creator_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'nameView' => 'Наименование',
            'description' => 'Описание товара',
            'photo' => 'Изображение товара',
            'photosFile' => 'Изображение товара',
            'photosView' => 'Изображение товара',
            'currency_id' => 'Валюта',
            'currencyString' => 'Валюта',
            'price' => 'Стоимость',
            'priceString' => 'Стоимость',
            'user_creator_id' => 'User Creator ID',
            'count' => 'Количество товара',
            'status_id' => 'Status ID',
            'acquisition' => 'Продажи',
            'statusString' => 'Статус товара',
        ];
    }

    public function getNameView()
    {
        return Html::a($this->name, \yii\helpers\Url::to(['product/view', 'id' => $this->id]));
    }

    public function getStatusString()
    {
        return $this->status->name;
    }

    public function getAcquisition()
    {
        $buyInfo = ProductUser::find()->where(['product_id' => $this->id])->orderBy(['date' => SORT_ASC])->all();
        $result = '<table><tr><td>Дата покупки</td><td>Покупатель</td><td style="width: 275px;">Статус</td></tr>';
        foreach ($buyInfo as $info)
        {
            if ($info->confirm_id == 1)
            {
                $confirm = '<div style="float: left;">' . Html::a('Подтвердить', ['confirm', 'user_id' => $info->user_id, 'product_id' => $info->product_id], ['class' => 'btn btn-success'])
                    . '</div><div style="float: right;">' . Html::a('Отклонить', ['refund', 'user_id' => $info->user_id, 'product_id' => $info->product_id], ['class' => 'btn btn-danger']) . '</div>';
            }
            else
                $confirm = $info->confirm->name;//'Подтверждено';
            $result .= '<tr><td>'.$info->date.'</td><td>'. $info->user->username .'</td><td>'. $confirm .'</td>'.'</tr>';
        }
        $result .= '</table>';
        return $result;
    }

    public function getPhotosView()
    {
        $split = explode(" ", $this->photo);
        $result = '';
        for ($i = 0; $i < count($split)-1; $i++)
            $result .= '<img src="/upload/product/'. $split[$i] .'" width="250">';
        return $result;
    }

    public function getPriceString()
    {
        return $this->price . ' ' . $this->currency->name;
    }

    public function getCurrencyString()
    {
        return $this->currency->name;
    }

    public function getButton($id)
    {
        $buyInfo = ProductUser::find()->where(['product_id' => $id])->andWhere(['user_id' => Yii::$app->user->identity->getId()])->andWhere(['confirm_id' => 1])->all();
        if (empty($buyInfo))
            return true;
        else
            return false;
    }

    public function getBuyInfo($id)
    {
        $buyInfo = ProductUser::find()->where(['product_id' => $id])->andWhere(['confirm_id' => 1])->all();
        if (!empty($buyInfo))
            return true;
        else
            return false;
    }

    public function uploadPhotosFile($upd = null)
    {
        $path = 'web/upload/product/';
        $result = '';
        $counter = 0;
        if (strlen($this->photo) > 3)
            $counter = count(explode(" ", $this->photo)) - 1;
        foreach ($this->photosFile as $file) {
            $counter++;
            $filename = '';
            $filename = 'Фото'.$counter.'_'. $this->name .'_'.$this->id;
            $res = mb_ereg_replace('[ ]{1,}', '_', $filename);
            $res = FileWizard::CutFilename($res);
            $res = mb_ereg_replace('[^а-яА-Я0-9a-zA-Z._]{1}', '', $res);
            $res = $this->resetFilename($path, $res, $file->extension);
            $path = '@app/web/upload/product/';
            $file->saveAs($path . $res . '.' . $file->extension);
            $result = $result.$res . '.' . $file->extension.' ';
        }
        if ($upd == null)
            $this->photo = $result;
        else
            $this->photo = $this->photo.$result;

        return true;
    }

    public function resetFilename($path, $file, $ext)
    {
        if (file_exists(Yii::$app->basePath . $path . $file . '.' . $ext))
        {
            $counter = 1;
            $tempName = Yii::$app->basePath . $path . $file . '.' . $ext;
            while (file_exists($tempName)) {
                if (substr($file, '-1') !== ')')
                    $file .= '(' . $counter . ')';
                else {
                    while (substr($file, -1) !== '(')
                        $file = substr($file, 0, -1);
                    $file = substr($file, 0, -1);
                    $file .= '(' . $counter . ')';
                    $counter++;
                }
                $tempName = Yii::$app->basePath . $path . $file . '.' . $ext;
            }
        }
        return $file;
    }

    /**
     * Gets query for [[Currency]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::class, ['id' => 'currency_id']);
    }

    /**
     * Gets query for [[ProductUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductUsers()
    {
        return $this->hasMany(ProductUser::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(StatusProduct::class, ['id' => 'status_id']);
    }

    /**
     * Gets query for [[UserCreator]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCreator()
    {
        return $this->hasOne(User::class, ['id' => 'user_creator_id']);
    }
}
