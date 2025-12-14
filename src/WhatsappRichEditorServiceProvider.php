<?php

namespace Daljo25\WhatsappRichEditor;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Daljo25\WhatsappRichEditor\Commands\WhatsappRichEditorCommand;
use Daljo25\WhatsappRichEditor\Testing\TestsWhatsappRichEditor;

class WhatsappRichEditorServiceProvider extends PackageServiceProvider
{
    public static string $name = 'whatsapp-rich-editor';

    public static string $viewNamespace = 'whatsapp-rich-editor';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('daljo25/whatsapp-rich-editor');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/whatsapp-rich-editor/{$file->getFilename()}"),
                ], 'whatsapp-rich-editor-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsWhatsappRichEditor);
    }

    protected function getAssetPackageName(): ?string
    {
        return 'daljo25/whatsapp-rich-editor';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('whatsapp-rich-editor', __DIR__ . '/../resources/dist/components/whatsapp-rich-editor.js'),
            Css::make('whatsapp-rich-editor-styles', __DIR__ . '/../resources/dist/whatsapp-rich-editor.css'),
            Js::make('whatsapp-rich-editor-scripts', __DIR__ . '/../resources/dist/whatsapp-rich-editor.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            WhatsappRichEditorCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_whatsapp-rich-editor_table',
        ];
    }

    public function boot(): void
    {
        // Cargar las vistas del plugin
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'whatsapp-rich-editor');
    }
}
