<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-05-23
 * Time: 11:59
 */

namespace app\cabinet\controllers;


use app\common\models\Organization;
use kartik\mpdf\Pdf;
use Yii;
use yii\web\Controller;

class ReportController extends Controller
{

    /**
     * @param $date
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex($date)
    {
        $startDate = new \DateTime('01-' . $date . ' 00:00:00');


        $endDate = clone $startDate;
        $endDate = $endDate->modify('last day of this month');

        /** @var Organization $organization */
        $organization = Yii::$app->getUser()->getIdentity();

        if (is_string($organization->proposal_search)) {
            $organization->proposal_search = unserialize(base64_decode($organization->proposal_search));
        }


        $searchModel = $organization->proposal_search;
        $query = $searchModel->search([]);
        $proposals = $query->query
            ->andFilterWhere(['between', 'created_at', $startDate->getTimestamp(), $endDate->getTimestamp()])
            ->orderBy('created_at')
            ->all();

//        $proposals = Proposal::find()
//            ->where(['between', 'created_at', $startDate->getTimestamp(), $endDate->getTimestamp()])
//            ->orderBy('created_at')
//            ->all();


        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'application/pdf');
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            'content' => $this->renderPartial('viewpdf', ['proposals' => $proposals, 'startDate' => $startDate]),
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.img-circle {border-radius: 50%;}',
            'options' => [
                'title' => 'Банкетные заявки',
                'subject' => 'PDF'
            ],
            'methods' => [
                'SetFooter' => ['|{PAGENO}|'],
            ]
        ]);
        return $pdf->render();
    }

}