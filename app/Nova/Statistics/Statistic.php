<?php

namespace App\Nova\Statistics;

use App\Models\Topic;
use App\Models\User;
use Coroowicaksono\ChartJsIntegration\LineChart;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\This;

class Statistic
{
    /**
     * 获取 7 天统计情况
     * @return LineChart
     */
    public static function getUserStatistic()
    {
        $time1 = static::getContinueDate();
        $res1 = static::getModelRecentlyCount(new User,$time1);

        $time2 = static::getContinueDate(7,'-7 days');
        $res2 = static::getModelRecentlyCount(new User,$time2,'-14 days', '-7 days');
        return (new LineChart())
            ->title('用户增长趋势')
            ->animations([
                'enabled' => true,
                'easing' => 'easeinout',
            ])
            ->series([[
                'barPercentage' => 0.5,
                'label' => date('Y-m-d',strtotime('-7 days')).'——'.date('Y-m-d',strtotime('now')),
                'borderColor' => '#f7a35c',
                'data' => array_values($res1),
            ],[
                'barPercentage' => 0.5,
                'label' => date('Y-m-d',strtotime('-14 days')).'——'.date('Y-m-d',strtotime('-7 days')),
                'borderColor' => '#90ed7d',
                'data' => array_values($res2),
                ]])
            ->options([
                'xaxis' => [
                    'categories' => array_keys($res1)
                ],
            ])
            ->width('2/3');
    }

    /**
     * @return LineChart
     */
    public static function getTopicStatistic()
    {
        $time1 = static::getContinueDate();
        $res1 = static::getModelRecentlyCount(new Topic,$time1);

        $time2 = static::getContinueDate(7,'-7 days');
        $res2 = static::getModelRecentlyCount(new Topic,$time2,'-14 days', '-7 days');


        return (new LineChart())
            ->title('话题增长趋势')
            ->animations([
                'enabled' => true,
                'easing' => 'easeinout',
            ])
            ->series([[
                'barPercentage' => 0.5,
                'label' => date('Y-m-d',strtotime('-7 days')).'——'.date('Y-m-d',strtotime('now')),
                'borderColor' => '#f7a35c',
                'data' => array_values($res1),
            ],[
                'barPercentage' => 0.5,
                'label' => date('Y-m-d',strtotime('-14 days')).'——'.date('Y-m-d',strtotime('-7 days')),
                'borderColor' => '#90ed7d',
                'data' => array_values($res2),
            ]])
            ->options([
                'xaxis' => [
                    'categories' => array_keys($res1)
                ],
            ])
            ->width('2/3');
    }


    protected static function getContinueDate($count = 7, $startDate = 'now')
    {
        $startTime = strtotime($startDate);
        $res[date('Y-m-d', $startTime)] = 0;
        for ($i = 1; $i < $count; $i++) {
            $res[date('Y-m-d', $startTime - $i * 24 * 60 * 60)] = 0;
        }
        return array_reverse($res);
    }

    protected static function getModelRecentlyCount($model, $between ,$start = '-7 days', $end = '+1 day')
    {
        $start = date('Y-m-d',strtotime($start));
        $end = date('Y-m-d',strtotime($end));
        $res = $between;
        $datas = $model::query()->selectRaw("count(*) num, DATE_FORMAT(created_at,'%Y-%m-%d') date")
            ->whereBetween('created_at', [$start, $end])
            ->groupBy("date")->orderBy('date')->get();
        foreach ($datas as $data) {
            if (key_exists($data->date, $res)) {
                $res[$data->date] = $data->num;
            }
        }
        return $res;
    }
}
