<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Tests\Unit\Services;

use Illuminate\Session\SessionManager;
use BrickNPC\EloquentUI\Tests\TestCase;
use BrickNPC\EloquentUI\Enums\ToastTheme;
use BrickNPC\EloquentUI\Services\Toaster;
use BrickNPC\EloquentUI\ValueObjects\Toast;
use Illuminate\Contracts\Config\Repository;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

/**
 * @internal
 */
#[CoversClass(Toaster::class)]
#[UsesClass(ToastTheme::class)]
class ToasterTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private Toaster $toaster;
    private SessionManager $session;
    private Repository $config;

    protected function setUp(): void
    {
        parent::setUp();

        $this->session = \Mockery::mock(SessionManager::class);
        $this->config  = \Mockery::mock(Repository::class);
        $this->toaster = new Toaster($this->session, $this->config);

        $this->config
            ->shouldReceive('get')
            ->with('eloquent-ui.toasts.autohide')
            ->zeroOrMoreTimes()
            ->andReturn(true)
        ;

        $this->config
            ->shouldReceive('get')
            ->with('eloquent-ui.toasts.autohide-delay')
            ->zeroOrMoreTimes()
            ->andReturn(5000)
        ;

        $this->config
            ->shouldReceive('get')
            ->with('eloquent-ui.toasts.border-theme')
            ->zeroOrMoreTimes()
            ->andReturn('dark')
        ;
    }

    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }

    // Basic functionality tests

    public function test_it_has_correct_flash_key_constant(): void
    {
        $this->assertSame('__toasts', Toaster::FLASH_KEY);
    }

    public function test_it_flashes_a_toast_to_session(): void
    {
        $toast = new Toast(
            title: 'Test Title',
            message: 'Test Message',
            theme: ToastTheme::Success,
            autohide: true,
            autohideDelayInMs: 5000,
            borderTheme: 'dark',
        );

        $this->session
            ->shouldReceive('get')
            ->once()
            ->with(Toaster::FLASH_KEY, [])
            ->andReturn([])
        ;

        $this->session
            ->shouldReceive('flash')
            ->once()
            ->with(Toaster::FLASH_KEY, [$toast])
        ;

        $this->toaster->toast($toast);
    }

    public function test_it_appends_toast_to_existing_toasts(): void
    {
        $existingToast = new Toast('Existing', null, ToastTheme::Info, true, 5000, 'dark');
        $newToast      = new Toast('New', null, ToastTheme::Success, true, 5000, 'dark');

        $this->session
            ->shouldReceive('get')
            ->once()
            ->with(Toaster::FLASH_KEY, [])
            ->andReturn([$existingToast])
        ;

        $this->session
            ->shouldReceive('flash')
            ->once()
            ->with(Toaster::FLASH_KEY, [$existingToast, $newToast])
        ;

        $this->toaster->toast($newToast);
    }

    public function test_it_gets_toasts_from_session(): void
    {
        $toast1 = new Toast('Toast 1', null, ToastTheme::Warning, true, 5000, 'dark');
        $toast2 = new Toast('Toast 2', null, ToastTheme::Success, true, 5000, 'dark');

        $this->session
            ->shouldReceive('get')
            ->once()
            ->with(Toaster::FLASH_KEY, [])
            ->andReturn([$toast1, $toast2])
        ;

        $result = $this->toaster->getToasts();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertSame($toast1, $result[0]);
        $this->assertSame($toast2, $result[1]);
    }

    public function test_it_returns_empty_array_when_no_toasts_in_session(): void
    {
        $this->session
            ->shouldReceive('get')
            ->once()
            ->with(Toaster::FLASH_KEY, [])
            ->andReturn([])
        ;

        $result = $this->toaster->getToasts();

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    // Info toast tests

    public function test_it_creates_info_toast_with_all_parameters(): void
    {
        $this->session->shouldReceive('get')->once()->andReturn([]);

        $this->session
            ->shouldReceive('flash')
            ->once()
            ->with(Toaster::FLASH_KEY, \Mockery::on(function ($toasts) {
                $toast = $toasts[0];
                $this->assertInstanceOf(Toast::class, $toast);
                $this->assertSame('Info Title', $toast->title);
                $this->assertSame('Info Message', $toast->message);
                $this->assertSame(ToastTheme::Info, $toast->theme);
                $this->assertFalse($toast->autohide);
                $this->assertSame(3000, $toast->autohideDelayInMs);
                $this->assertSame('primary', $toast->borderTheme);

                return true;
            }))
        ;

        $this->toaster->info('Info Title', 'Info Message', false, 3000, 'primary');
    }

    public function test_it_creates_info_toast_with_defaults(): void
    {
        $this->session->shouldReceive('get')->once()->andReturn([]);

        $this->session
            ->shouldReceive('flash')
            ->once()
            ->with(Toaster::FLASH_KEY, \Mockery::on(function ($toasts) {
                $toast = $toasts[0];
                $this->assertSame(ToastTheme::Info, $toast->theme);
                $this->assertSame('Info Title', $toast->title);
                $this->assertNull($toast->message);
                $this->assertTrue($toast->autohide);
                $this->assertSame(5000, $toast->autohideDelayInMs);
                $this->assertSame('dark', $toast->borderTheme);

                return true;
            }))
        ;

        $this->toaster->info('Info Title');
    }

    public function test_it_creates_info_toast_with_partial_defaults(): void
    {
        $this->session->shouldReceive('get')->once()->andReturn([]);

        $this->session
            ->shouldReceive('flash')
            ->once()
            ->with(Toaster::FLASH_KEY, \Mockery::on(function ($toasts) {
                $toast = $toasts[0];
                $this->assertFalse($toast->autohide);
                $this->assertSame(5000, $toast->autohideDelayInMs);
                $this->assertSame('dark', $toast->borderTheme);

                return true;
            }))
        ;

        $this->toaster->info('Info', 'Message', false);
    }

    // Success toast tests

    public function test_it_creates_success_toast_with_all_parameters(): void
    {
        $this->session->shouldReceive('get')->once()->andReturn([]);

        $this->session
            ->shouldReceive('flash')
            ->once()
            ->with(Toaster::FLASH_KEY, \Mockery::on(function ($toasts) {
                $toast = $toasts[0];
                $this->assertSame(ToastTheme::Success, $toast->theme);
                $this->assertSame('Success Title', $toast->title);
                $this->assertSame('Success Message', $toast->message);
                $this->assertFalse($toast->autohide);
                $this->assertSame(10000, $toast->autohideDelayInMs);
                $this->assertSame('success', $toast->borderTheme);

                return true;
            }))
        ;

        $this->toaster->success('Success Title', 'Success Message', false, 10000, 'success');
    }

    public function test_it_creates_success_toast_with_defaults(): void
    {
        $this->session->shouldReceive('get')->once()->andReturn([]);

        $this->session
            ->shouldReceive('flash')
            ->once()
            ->with(Toaster::FLASH_KEY, \Mockery::on(function ($toasts) {
                $toast = $toasts[0];
                $this->assertSame(ToastTheme::Success, $toast->theme);

                return true;
            }))
        ;

        $this->toaster->success('Success Title');
    }

    // Warning toast tests

    public function test_it_creates_warning_toast_with_all_parameters(): void
    {
        $this->session->shouldReceive('get')->once()->andReturn([]);

        $this->session
            ->shouldReceive('flash')
            ->once()
            ->with(Toaster::FLASH_KEY, \Mockery::on(function ($toasts) {
                $toast = $toasts[0];
                $this->assertSame(ToastTheme::Warning, $toast->theme);
                $this->assertSame('Warning Title', $toast->title);
                $this->assertSame('Warning Message', $toast->message);
                $this->assertTrue($toast->autohide);
                $this->assertSame(7000, $toast->autohideDelayInMs);
                $this->assertSame('warning', $toast->borderTheme);

                return true;
            }))
        ;

        $this->toaster->warning('Warning Title', 'Warning Message', true, 7000, 'warning');
    }

    public function test_it_creates_warning_toast_with_defaults(): void
    {
        $this->session->shouldReceive('get')->once()->andReturn([]);

        $this->session
            ->shouldReceive('flash')
            ->once()
            ->with(Toaster::FLASH_KEY, \Mockery::on(function ($toasts) {
                $toast = $toasts[0];
                $this->assertSame(ToastTheme::Warning, $toast->theme);

                return true;
            }))
        ;

        $this->toaster->warning('Warning Title');
    }

    // Error toast tests

    public function test_it_creates_error_toast_with_all_parameters(): void
    {
        $this->session->shouldReceive('get')->once()->andReturn([]);

        $this->session
            ->shouldReceive('flash')
            ->once()
            ->with(Toaster::FLASH_KEY, \Mockery::on(function ($toasts) {
                $toast = $toasts[0];
                $this->assertSame(ToastTheme::Danger, $toast->theme);
                $this->assertSame('Error Title', $toast->title);
                $this->assertSame('Error Message', $toast->message);
                $this->assertTrue($toast->autohide);
                $this->assertSame(5000, $toast->autohideDelayInMs);
                $this->assertSame('danger', $toast->borderTheme);

                return true;
            }))
        ;

        $this->toaster->error('Error Title', 'Error Message', true, 5000, 'danger');
    }

    public function test_it_creates_error_toast_with_defaults(): void
    {
        $this->session->shouldReceive('get')->once()->andReturn([]);

        $this->session
            ->shouldReceive('flash')
            ->once()
            ->with(Toaster::FLASH_KEY, \Mockery::on(function ($toasts) {
                $toast = $toasts[0];
                $this->assertSame(ToastTheme::Danger, $toast->theme);

                return true;
            }))
        ;

        $this->toaster->error('Error Title');
    }

    // Danger toast tests

    public function test_it_creates_danger_toast_with_all_parameters(): void
    {
        $this->session->shouldReceive('get')->once()->andReturn([]);

        $this->session
            ->shouldReceive('flash')
            ->once()
            ->with(Toaster::FLASH_KEY, \Mockery::on(function ($toasts) {
                $toast = $toasts[0];
                $this->assertSame(ToastTheme::Danger, $toast->theme);
                $this->assertSame('Danger Title', $toast->title);
                $this->assertSame('Danger Message', $toast->message);
                $this->assertFalse($toast->autohide);
                $this->assertSame(8000, $toast->autohideDelayInMs);
                $this->assertSame('danger', $toast->borderTheme);

                return true;
            }))
        ;

        $this->toaster->danger('Danger Title', 'Danger Message', false, 8000, 'danger');
    }

    public function test_it_creates_danger_toast_with_defaults(): void
    {
        $this->session->shouldReceive('get')->once()->andReturn([]);

        $this->session
            ->shouldReceive('flash')
            ->once()
            ->with(Toaster::FLASH_KEY, \Mockery::on(function ($toasts) {
                $toast = $toasts[0];
                $this->assertSame(ToastTheme::Danger, $toast->theme);

                return true;
            }))
        ;

        $this->toaster->danger('Danger Title');
    }

    // Parameter variation tests

    #[DataProvider('toastParameterProvider')]
    public function test_it_handles_various_parameter_combinations(
        string $method,
        ?string $message,
        bool $autohide,
        int $delay,
        string $borderTheme,
    ): void {
        $this->session->shouldReceive('get')->once()->andReturn([]);

        $this->session
            ->shouldReceive('flash')
            ->once()
            ->with(Toaster::FLASH_KEY, \Mockery::on(function ($toasts) use ($message, $autohide, $delay, $borderTheme) {
                $toast = $toasts[0];
                $this->assertInstanceOf(Toast::class, $toast);
                $this->assertSame($message, $toast->message);
                $this->assertSame($autohide, $toast->autohide);
                $this->assertSame($delay, $toast->autohideDelayInMs);
                $this->assertSame($borderTheme, $toast->borderTheme);

                return true;
            }))
        ;

        $this->toaster->{$method}('Title', $message, $autohide, $delay, $borderTheme);
    }

    public static function toastParameterProvider(): array
    {
        return [
            'info with custom message and settings' => [
                'info', 'Custom message', false, 10000, 'primary',
            ],
            'success with null message' => [
                'success', null, true, 5000, 'success',
            ],
            'warning no autohide' => [
                'warning', 'Warning!', false, 0, 'warning',
            ],
            'error with long delay' => [
                'error', 'Error occurred', true, 15000, 'danger',
            ],
            'danger with short delay' => [
                'danger', 'Danger!', true, 1000, 'dark',
            ],
        ];
    }

    // Multiple toasts tests

    public function test_it_can_add_multiple_toasts_in_sequence(): void
    {
        // First toast
        $this->session->shouldReceive('get')->once()->andReturn([]);
        $this->session->shouldReceive('flash')->once();

        $this->toaster->success('Toast 1');

        // Second toast
        $firstToast = new Toast('Toast 1', null, ToastTheme::Success, true, 5000, 'dark');
        $this->session->shouldReceive('get')->once()->andReturn([$firstToast]);
        $this->session->shouldReceive('flash')->once();

        $this->toaster->warning('Toast 2');

        // Third toast
        $secondToast = new Toast('Toast 2', null, ToastTheme::Warning, true, 5000, 'dark');
        $this->session->shouldReceive('get')->once()->andReturn([$firstToast, $secondToast]);
        $this->session->shouldReceive('flash')->once();

        $this->toaster->error('Toast 3');
    }

    public function test_it_can_add_toasts_of_different_types(): void
    {
        $this->session->shouldReceive('get')->times(4)->andReturn([]);
        $this->session->shouldReceive('flash')->times(4);

        $this->toaster->info('Info');
        $this->toaster->success('Success');
        $this->toaster->warning('Warning');
        $this->toaster->danger('Danger');
    }

    // Edge cases

    public function test_it_handles_empty_title(): void
    {
        $this->session->shouldReceive('get')->once()->andReturn([]);

        $this->session
            ->shouldReceive('flash')
            ->once()
            ->with(Toaster::FLASH_KEY, \Mockery::on(function ($toasts) {
                $this->assertSame('', $toasts[0]->title);

                return true;
            }))
        ;

        $this->toaster->success('');
    }

    public function test_it_handles_very_long_title(): void
    {
        $longTitle = str_repeat('Long title ', 100);

        $this->session->shouldReceive('get')->once()->andReturn([]);

        $this->session
            ->shouldReceive('flash')
            ->once()
            ->with(Toaster::FLASH_KEY, \Mockery::on(function ($toasts) use ($longTitle) {
                $this->assertSame($longTitle, $toasts[0]->title);

                return true;
            }))
        ;

        $this->toaster->success($longTitle);
    }

    public function test_it_handles_very_long_message(): void
    {
        $longMessage = str_repeat('Long message ', 200);

        $this->session->shouldReceive('get')->once()->andReturn([]);

        $this->session
            ->shouldReceive('flash')
            ->once()
            ->with(Toaster::FLASH_KEY, \Mockery::on(function ($toasts) use ($longMessage) {
                $this->assertSame($longMessage, $toasts[0]->message);

                return true;
            }))
        ;

        $this->toaster->info('Title', $longMessage);
    }

    public function test_it_handles_special_characters_in_title(): void
    {
        $specialTitle = '<script>alert("XSS")</script>';

        $this->session->shouldReceive('get')->once()->andReturn([]);

        $this->session
            ->shouldReceive('flash')
            ->once()
            ->with(Toaster::FLASH_KEY, \Mockery::on(function ($toasts) use ($specialTitle) {
                $this->assertSame($specialTitle, $toasts[0]->title);

                return true;
            }))
        ;

        $this->toaster->warning($specialTitle);
    }

    public function test_it_handles_special_characters_in_message(): void
    {
        $specialMessage = 'Message with "quotes" and \'apostrophes\' & symbols';

        $this->session->shouldReceive('get')->once()->andReturn([]);

        $this->session
            ->shouldReceive('flash')
            ->once()
            ->with(Toaster::FLASH_KEY, \Mockery::on(function ($toasts) use ($specialMessage) {
                $this->assertSame($specialMessage, $toasts[0]->message);

                return true;
            }))
        ;

        $this->toaster->danger('Title', $specialMessage);
    }

    public function test_it_handles_zero_autohide_delay(): void
    {
        $this->session->shouldReceive('get')->once()->andReturn([]);

        $this->session
            ->shouldReceive('flash')
            ->once()
            ->with(Toaster::FLASH_KEY, \Mockery::on(function ($toasts) {
                $this->assertSame(0, $toasts[0]->autohideDelayInMs);

                return true;
            }))
        ;

        $this->toaster->success('Title', 'Message', true, 0, 'dark');
    }

    public function test_it_handles_very_large_autohide_delay(): void
    {
        $this->session->shouldReceive('get')->once()->andReturn([]);

        $this->session
            ->shouldReceive('flash')
            ->once()
            ->with(Toaster::FLASH_KEY, \Mockery::on(function ($toasts) {
                $this->assertSame(999999, $toasts[0]->autohideDelayInMs);

                return true;
            }))
        ;

        $this->toaster->success('Title', 'Message', true, 999999, 'dark');
    }

    // Border theme tests

    #[DataProvider('borderThemeProvider')]
    public function test_it_handles_various_border_themes(string $borderTheme): void
    {
        $this->session->shouldReceive('get')->once()->andReturn([]);

        $this->session
            ->shouldReceive('flash')
            ->once()
            ->with(Toaster::FLASH_KEY, \Mockery::on(function ($toasts) use ($borderTheme) {
                $this->assertSame($borderTheme, $toasts[0]->borderTheme);

                return true;
            }))
        ;

        $this->toaster->info('Title', null, true, 5000, $borderTheme);
    }

    public static function borderThemeProvider(): array
    {
        return [
            'primary'   => ['primary'],
            'secondary' => ['secondary'],
            'success'   => ['success'],
            'danger'    => ['danger'],
            'warning'   => ['warning'],
            'info'      => ['info'],
            'light'     => ['light'],
            'dark'      => ['dark'],
        ];
    }
}
