<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class AppServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        \Blade::directive('sortablelink', function ($expression) {
            $params = explode(',', $expression, 2);
            $field = trim($params[0]);
            $label = trim($params[1] ?? "'$field'");
            
            return "<?php echo \App\Helpers\SortableLink::render($field, $label); ?>";
        });
    }
}
