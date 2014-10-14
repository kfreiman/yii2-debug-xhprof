<?php
namespace trntv\debug\xhprof\models\search;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\debug\components\search\Filter;

/**
 * Author: Eugine Terentev <eugine@terentev.net>
 */

class Xhprof extends Model
{
    public $fn;
    public $ct;
    public $wt;
    public $cpu;
    public $mu;
    public $pmu;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['function'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            // todo
        ];
    }

    /**
     * Returns data provider with filled models. Filter applied if needed.
     *
     * @param array $params an array of parameter values indexed by parameter names
     * @param array $models data to return provider for
     * @return \yii\data\ArrayDataProvider
     */
    public function search($params, $models)
    {
        $dataProvider = new ArrayDataProvider([
            'allModels' => $models,
            'sort' => [
                'attributes' => ['fn', 'ct', 'w_ct', 'wt', 'w_wt', 'cpu', 'w_cpu', 'mu', 'w_mu', 'pmu'],
                'defaultOrder' => [
                    'w_ct' => SORT_DESC,
                ],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $filter = new Filter();
        $this->addCondition($filter, 'fn', true);

        return $dataProvider;
    }
} 