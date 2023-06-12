<?php

namespace app\controllers;

use app\models\FileUploadModel;
use app\models\Picture;
use app\models\PictureSearch;
use app\models\PictureUploadModel;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PictureController implements the CRUD actions for Picture model.
 */
class PictureController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'accessControl' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['handle-upload'],
                            'matchCallback' => function ($rule, $action) {
                                // @todo: check if user is allowed to upload pictures
                                return true;
                            }
                        ],
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ]
                ]
            ]
        );
    }


    /**
     * This action handles the upload request from FileUploadUi widget
     * @param $id
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionHandleUpload()
    {
        $model = new PictureUploadModel();
        $model->file = \yii\web\UploadedFile::getInstance($model, 'file');
        try {
            $status = $model->upload();
            if ($model->hasErrors()) {
                $status = false;
            }
        } catch (\Exception $e) {
            $status = false;
            $model->addError('files', $e->getMessage());
        }

        $file = $model->file;
        // format output to compat with fileuploadui
        $uploadedFiles = [
            'name' => $file->name,
            'size' => $file->size,
            'status' => $status ? 'success' : 'error',
        ];
        if (!empty($model->errors)) {
            $uploadedFiles['error'] = $model->getfirstError('file');
        }
        return $this->asJson([
            'files' => [$uploadedFiles],
            'success' => $status,
        ]);
    }

    /**
     * Lists all Picture models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PictureSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Picture model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Picture model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Picture();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Picture model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Picture model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Picture model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Picture the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Picture::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('xenon', 'The requested page does not exist.'));
    }
}
