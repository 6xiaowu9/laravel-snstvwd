<?php

namespace Snstvwd\Filter\Providers;

use Snstvwd\Filter\Kernel\Filter;
use Snstvwd\Filter\Kernel\TextProcessor;
use Illuminate\Support\ServiceProvider;

class FilterSerivceProvider extends ServiceProvider
{
   /**
     * 服务提供者加是否延迟加载.
     *
     * @var bool
     */
    protected $defer = true; // 延迟加载服务

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/filter.php' => config_path('filter.php'), // 发布配置文件到 laravel 的config 下
        ]);
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
         // 单例绑定服务
        $this->app->singleton('filter', function ($app) {
            return new Filter($app['config']);
        });
         // 绑定服务
        $this->app->bind('textprocessor', function ($app) {
            return new TextProcessor($app['config']);
        });
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        // 因为延迟加载 所以要定义 provides 函数 具体参考laravel 文档
        return ['filter', 'textprocessor'];
    }
}
