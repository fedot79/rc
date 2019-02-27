<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 01.08.2018
 * Time: 16:55
 */

namespace app\assets;
use Yii;

class AssetConverter extends \yii\web\AssetConverter
{
    public function convert($asset, $basePath)
    {
        $pos = strrpos($asset, '.');
        if ($pos !== false) {
            $ext = substr($asset, $pos + 1);
            if (isset($this->commands[$ext])) {
                list($ext, $command) = $this->commands[$ext];
                $result = substr($asset, 0, $pos + 1) . $ext;
                Yii::info(print_r(["$basePath/$result","$basePath/$asset", @filemtime("$basePath/$result") < @filemtime("$basePath/$asset")], true));


                if ($this->forceConvert || @filemtime("$basePath/$result") < @filemtime("$basePath/$asset")) {
                    $this->runCommand($command, $basePath, $asset, $result);
                }

                return $result;
            }
        }

        return $asset;
    }
}