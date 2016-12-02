<?php
namespace console\controllers;

use yii\console\Controller;

class CrawlerController extends Controller
{
    const DEFAULT_LAST_ID = 3155690;

    public function actionEmailGrabber()
    {
        $lastContentId = $this->getLastContentId();
        $notFoundCount = 0;
        while (true) {
            $lastContentId = $lastContentId + 1;
            try {
                $content = $this->getGrabbedContent($lastContentId);
                if ($content) {
                    $this->saveContent($lastContentId, $content);
                } else {
                    $notFoundCount++;
                }
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
            echo $lastContentId;
            echo PHP_EOL;
            if ($notFoundCount > 20) {
                echo 'NOT FOUND more than 20 ids';
                break;
            }
            sleep(1);
        }
    }

    protected function getLastContentId()
    {
        $sql = "SELECT
                  contentId
              FROM contentGrabber
              ORDER BY id DESC
              LIMIT 1";
        $contentId = \Yii::$app->grabberDb
            ->createCommand($sql)
            ->queryScalar();

        return (!empty($contentId)) ? $contentId : self::DEFAULT_LAST_ID;
    }

    protected function getGrabbedContent($contentId)
    {
        $url = "http://www.zapchast.com.ua/account/ajax_getleaddata.php?lead_id={$contentId}&v_id=20919";
        $ch = curl_init ($url);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: uid=b0a72a0efaab6fb0e87fad94a1f66df2; PHPSESSID=hlmfoj7chjvuq2jdudg0s1nuh1"));
        $output = iconv("windows-1251","utf-8", curl_exec($ch));
        curl_close($ch);

        return $output;
    }

    protected function saveContent($contentId, $content)
    {
        $content = str_replace("\r\n", '', $content);
//        $content = str_replace("\n", '', $content);
//        $sql = "INSERT INTO contentGrabber(contentId, content) VALUES ({$contentId}, '{$content}')";
//        echo $sql;die;
        \Yii::$app->grabberDb
            ->createCommand()
            ->insert(
                'contentGrabber',
                [
                    'contentId' => $contentId,
                    'content' => $content
                ]
            )
            ->execute();
    }
}