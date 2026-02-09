<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Services;

use Illuminate\Session\SessionManager;
use BrickNPC\EloquentUI\Enums\ToastTheme;
use BrickNPC\EloquentUI\ValueObjects\Toast;
use Illuminate\Contracts\Config\Repository;

readonly class Toaster
{
    public const string FLASH_KEY = '__toasts';

    public function __construct(
        private SessionManager $session,
        private Repository $config,
    ) {}

    public function toast(Toast $toast): void
    {
        $toasts = $this->getToasts();

        $toasts[] = $toast;

        $this->session->flash(self::FLASH_KEY, $toasts);
    }

    /**
     * @return Toast[]
     */
    public function getToasts(): array
    {
        /** @var Toast[] $toasts */
        $toasts = $this->session->get(self::FLASH_KEY, []);

        return $toasts;
    }

    public function info(
        string $title,
        ?string $message = null,
        ?bool $autohide = null,
        ?int $autohideDelayInMs = null,
        ?string $borderTheme = null,
    ): void {
        /** @var bool $autohideConfig */
        $autohideConfig = $this->config->get('eloquent-ui.toasts.autohide');

        /** @var int $autohideDelayInMsConfig */
        $autohideDelayInMsConfig = $this->config->get('eloquent-ui.toasts.autohide-delay');

        /** @var string $borderThemeConfig */
        $borderThemeConfig = $this->config->get('eloquent-ui.toasts.border-theme');

        $this->toast(new Toast(
            $title,
            $message,
            ToastTheme::Info,
            $autohide          ?? $autohideConfig,
            $autohideDelayInMs ?? $autohideDelayInMsConfig,
            $borderTheme       ?? $borderThemeConfig,
        ));
    }

    public function success(
        string $title,
        ?string $message = null,
        ?bool $autohide = null,
        ?int $autohideDelayInMs = null,
        ?string $borderTheme = null,
    ): void {
        /** @var bool $autohideConfig */
        $autohideConfig = $this->config->get('eloquent-ui.toasts.autohide');

        /** @var int $autohideDelayInMsConfig */
        $autohideDelayInMsConfig = $this->config->get('eloquent-ui.toasts.autohide-delay');

        /** @var string $borderThemeConfig */
        $borderThemeConfig = $this->config->get('eloquent-ui.toasts.border-theme');

        $this->toast(new Toast(
            $title,
            $message,
            ToastTheme::Success,
            $autohide          ?? $autohideConfig,
            $autohideDelayInMs ?? $autohideDelayInMsConfig,
            $borderTheme       ?? $borderThemeConfig,
        ));
    }

    public function warning(
        string $title,
        ?string $message = null,
        ?bool $autohide = null,
        ?int $autohideDelayInMs = null,
        ?string $borderTheme = null,
    ): void {
        /** @var bool $autohideConfig */
        $autohideConfig = $this->config->get('eloquent-ui.toasts.autohide');

        /** @var int $autohideDelayInMsConfig */
        $autohideDelayInMsConfig = $this->config->get('eloquent-ui.toasts.autohide-delay');

        /** @var string $borderThemeConfig */
        $borderThemeConfig = $this->config->get('eloquent-ui.toasts.border-theme');

        $this->toast(new Toast(
            $title,
            $message,
            ToastTheme::Warning,
            $autohide          ?? $autohideConfig,
            $autohideDelayInMs ?? $autohideDelayInMsConfig,
            $borderTheme       ?? $borderThemeConfig,
        ));
    }

    public function error(
        string $title,
        ?string $message = null,
        ?bool $autohide = null,
        ?int $autohideDelayInMs = null,
        ?string $borderTheme = null,
    ): void {
        /** @var bool $autohideConfig */
        $autohideConfig = $this->config->get('eloquent-ui.toasts.autohide');

        /** @var int $autohideDelayInMsConfig */
        $autohideDelayInMsConfig = $this->config->get('eloquent-ui.toasts.autohide-delay');

        /** @var string $borderThemeConfig */
        $borderThemeConfig = $this->config->get('eloquent-ui.toasts.border-theme');

        $this->toast(new Toast(
            $title,
            $message,
            ToastTheme::Danger,
            $autohide          ?? $autohideConfig,
            $autohideDelayInMs ?? $autohideDelayInMsConfig,
            $borderTheme       ?? $borderThemeConfig,
        ));
    }

    public function danger(
        string $title,
        ?string $message = null,
        ?bool $autohide = null,
        ?int $autohideDelayInMs = null,
        ?string $borderTheme = null,
    ): void {
        /** @var bool $autohideConfig */
        $autohideConfig = $this->config->get('eloquent-ui.toasts.autohide');

        /** @var int $autohideDelayInMsConfig */
        $autohideDelayInMsConfig = $this->config->get('eloquent-ui.toasts.autohide-delay');

        /** @var string $borderThemeConfig */
        $borderThemeConfig = $this->config->get('eloquent-ui.toasts.border-theme');

        $this->toast(new Toast(
            $title,
            $message,
            ToastTheme::Danger,
            $autohide          ?? $autohideConfig,
            $autohideDelayInMs ?? $autohideDelayInMsConfig,
            $borderTheme       ?? $borderThemeConfig,
        ));
    }
}
