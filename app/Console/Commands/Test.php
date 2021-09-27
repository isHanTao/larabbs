<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Test extends Command
{
    // 供我们调用命令
    protected $signature = 'test';

    // 命令的描述
    protected $description = '生成活跃用户';

    // 最终执行的方法
    public function handle(User $user)
    {
        Log::info('123123');
    }
}
