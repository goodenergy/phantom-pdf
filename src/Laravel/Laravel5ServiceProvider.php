<?php
namespace PhantomPdf\Laravel;

use Illuminate\Support\ServiceProvider;
use PhantomPdf\PdfGenerator;

class Laravel5ServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('phantom-pdf.php')
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'phantom-pdf');

        $this->app->singleton('phantom-pdf', function () {
            $generator = new PdfGenerator;

            $generator->setBaseUrl($this->app['config']['phantom-pdf.base_url'] ?: url('/'));

            $generator->setBinaryPath($this->app['config']['phantom-pdf.binary_path']);

            $generator->setStoragePath($this->app['config']['phantom-pdf.temporary_file_path']);

            $generator->setTimeout($this->app['config']['phantom-pdf.timeout']);

            $generator->useScript($this->app['config']['phantom-pdf.script'] ?: 'generate-pdf.js');

            foreach ($this->app['config']['phantom-pdf.command_line_options'] as $option) {
                $generator->addCommandLineOption($option);
            }

            return $generator;
        });

        $this->app->alias('phantom-pdf', PdfGenerator::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['phantom-pdf', PdfGenerator::class];
    }
}
