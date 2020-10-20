<?php

namespace PrettyRoutes;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\View\Compilers\Concerns\CompilesJson;

final class BladeServiceProvider extends BaseServiceProvider
{
    /**
     * The default JSON encoding options.
     *
     * @var int
     */
    protected $encoding_options = JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT;

    public function boot()
    {
        if ($this->allowRegister()) {
            $this->registerDirective();
        }
    }

    protected function allowRegister(): bool
    {
        return ! class_exists(CompilesJson::class);
    }

    /**
     * @see https://laravel.com/api/8.x/Illuminate/View/Compilers/Concerns/CompilesJson.html
     */
    protected function registerDirective(): void
    {
        Blade::directive('json', function ($expression) {
            $parts = explode(',', $this->stripParentheses($expression));

            $options = isset($parts[1]) ? trim($parts[1]) : $this->encoding_options;

            $depth = isset($parts[2]) ? trim($parts[2]) : 512;

            return "<?php echo json_encode($parts[0], $options, $depth) ?>";
        });
    }

    /**
     * Strip the parentheses from the given expression.
     *
     * @see https://laravel.com/api/8.x/Illuminate/View/Compilers/BladeCompiler.html#method_stripParentheses
     *
     * @param  string  $expression
     *
     * @return string
     */
    protected function stripParentheses($expression): string
    {
        if ($this->startsWith($expression, '(')) {
            $expression = substr($expression, 1, -1);
        }

        return $expression;
    }

    /**
     * Determine if a given string starts with a given substring.
     *
     * @see https://laravel.com/api/8.x/Illuminate/Support/Str.html#method_startsWith
     *
     * @param  string  $haystack
     * @param  string|string[]  $needles
     *
     * @return bool
     */
    protected function startsWith($haystack, $needles): bool
    {
        foreach ((array) $needles as $needle) {
            if ((string) $needle !== '' && strncmp($haystack, $needle, strlen($needle)) === 0) {
                return true;
            }
        }

        return false;
    }
}
