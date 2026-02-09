<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Tests\Unit\Http\Composers;

use Illuminate\Contracts\View\View;
use BrickNPC\EloquentUI\Tests\TestCase;
use BrickNPC\EloquentUI\Enums\ToastTheme;
use BrickNPC\EloquentUI\Services\Toaster;
use BrickNPC\EloquentUI\ValueObjects\Toast;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\CoversClass;
use BrickNPC\EloquentUI\Http\Composers\ToastComposer;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

/**
 * @internal
 */
#[CoversClass(ToastComposer::class)]
#[UsesClass(Toaster::class)]
#[UsesClass(ToastTheme::class)]
class ToastComposerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private ToastComposer $composer;
    private Toaster $toaster;
    private View $view;

    protected function setUp(): void
    {
        parent::setUp();

        $this->toaster  = resolve(Toaster::class);
        $this->view     = \Mockery::mock(View::class);
        $this->composer = new ToastComposer($this->toaster);
    }

    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function test_it_composes_view_with_empty_toasts_array(): void
    {
        $this->view
            ->shouldReceive('with')
            ->once()
            ->with('_eloquent_ui__toasts', [])
        ;

        $this->composer->compose($this->view);
    }

    public function test_it_composes_view_with_single_toast(): void
    {
        $toast = new Toast(
            title: 'Test Title',
            message: 'Test Message',
            theme: ToastTheme::Success,
            autohide: true,
            autohideDelayInMs: 5000,
            borderTheme: 'dark',
        );

        $this->toaster->toast($toast);

        $this->view
            ->shouldReceive('with')
            ->once()
            ->with('_eloquent_ui__toasts', [$toast])
        ;

        $this->composer->compose($this->view);
    }

    public function test_it_composes_view_with_multiple_toasts(): void
    {
        $toasts = [
            new Toast('Title 1', 'Message 1', ToastTheme::Info, true, 5000, 'dark'),
            new Toast('Title 2', 'Message 2', ToastTheme::Success, true, 5000, 'dark'),
            new Toast('Title 3', 'Message 3', ToastTheme::Warning, true, 5000, 'dark'),
        ];

        array_walk($toasts, fn (Toast $toast) => $this->toaster->toast($toast));

        $this->view
            ->shouldReceive('with')
            ->once()
            ->with('_eloquent_ui__toasts', $toasts)
        ;

        $this->composer->compose($this->view);
    }

    public function test_it_composes_view_with_different_toast_types(): void
    {
        $toasts = [
            new Toast('Info', null, ToastTheme::Info, true, 5000, 'dark'),
            new Toast('Success', null, ToastTheme::Success, true, 5000, 'dark'),
            new Toast('Warning', null, ToastTheme::Warning, true, 5000, 'dark'),
            new Toast('Danger', null, ToastTheme::Danger, true, 5000, 'dark'),
        ];

        array_walk($toasts, fn (Toast $toast) => $this->toaster->toast($toast));

        $this->view
            ->shouldReceive('with')
            ->once()
            ->with('_eloquent_ui__toasts', $toasts)
        ;

        $this->composer->compose($this->view);
    }

    public function test_it_composes_view_with_toasts_having_different_configurations(): void
    {
        $toasts = [
            new Toast('No autohide', 'Message', ToastTheme::Info, false, 0, 'primary'),
            new Toast('Short delay', 'Message', ToastTheme::Success, true, 1000, 'success'),
            new Toast('Long delay', 'Message', ToastTheme::Warning, true, 10000, 'warning'),
        ];

        array_walk($toasts, fn (Toast $toast) => $this->toaster->toast($toast));

        $this->view
            ->shouldReceive('with')
            ->once()
            ->with('_eloquent_ui__toasts', $toasts)
        ;

        $this->composer->compose($this->view);
    }

    public function test_it_uses_correct_view_variable_name(): void
    {
        $this->view
            ->shouldReceive('with')
            ->once()
            ->with('_eloquent_ui__toasts', \Mockery::any())
        ;

        $this->composer->compose($this->view);
    }

    public function test_it_passes_exact_array_from_toaster_to_view(): void
    {
        $toasts = [
            new Toast('Toast 1', 'Message 1', ToastTheme::Success, true, 5000, 'dark'),
            new Toast('Toast 2', 'Message 2', ToastTheme::Danger, false, 0, 'light'),
        ];

        array_walk($toasts, fn (Toast $toast) => $this->toaster->toast($toast));

        $this->view
            ->shouldReceive('with')
            ->once()
            ->with('_eloquent_ui__toasts', \Mockery::on(function ($passedToasts) use ($toasts) {
                $this->assertSame($toasts, $passedToasts);
                $this->assertCount(2, $passedToasts);
                $this->assertSame($toasts[0], $passedToasts[0]);
                $this->assertSame($toasts[1], $passedToasts[1]);

                return true;
            }))
        ;

        $this->composer->compose($this->view);
    }

    public function test_it_calls_toaster_get_toasts_method(): void
    {
        $this->view
            ->shouldReceive('with')
            ->once()
        ;

        $this->composer->compose($this->view);
    }

    public function test_it_calls_view_with_method(): void
    {
        $this->view
            ->shouldReceive('with')
            ->once()
            ->with(\Mockery::type('string'), \Mockery::type('array'))
        ;

        $this->composer->compose($this->view);
    }

    public function test_it_composes_view_with_toasts_containing_special_characters(): void
    {
        $toasts = [
            new Toast(
                '<script>alert("XSS")</script>',
                'Message with "quotes" & \'apostrophes\'',
                ToastTheme::Danger,
                true,
                5000,
                'dark',
            ),
        ];

        array_walk($toasts, fn (Toast $toast) => $this->toaster->toast($toast));

        $this->view
            ->shouldReceive('with')
            ->once()
            ->with('_eloquent_ui__toasts', $toasts)
        ;

        $this->composer->compose($this->view);
    }

    public function test_it_composes_view_with_toasts_containing_null_messages(): void
    {
        $toasts = [
            new Toast('Title only', null, ToastTheme::Info, true, 5000, 'dark'),
            new Toast('Another title', null, ToastTheme::Success, true, 5000, 'dark'),
        ];

        array_walk($toasts, fn (Toast $toast) => $this->toaster->toast($toast));

        $this->view
            ->shouldReceive('with')
            ->once()
            ->with('_eloquent_ui__toasts', $toasts)
        ;

        $this->composer->compose($this->view);
    }

    public function test_it_composes_view_with_toasts_having_various_border_themes(): void
    {
        $toasts = [
            new Toast('Primary', 'Message', ToastTheme::Info, true, 5000, 'primary'),
            new Toast('Secondary', 'Message', ToastTheme::Info, true, 5000, 'secondary'),
            new Toast('Success', 'Message', ToastTheme::Success, true, 5000, 'success'),
            new Toast('Danger', 'Message', ToastTheme::Danger, true, 5000, 'danger'),
        ];

        array_walk($toasts, fn (Toast $toast) => $this->toaster->toast($toast));

        $this->view
            ->shouldReceive('with')
            ->once()
            ->with('_eloquent_ui__toasts', $toasts)
        ;

        $this->composer->compose($this->view);
    }

    public function test_it_can_be_called_multiple_times(): void
    {
        $toasts = [new Toast('Test', null, ToastTheme::Info, true, 5000, 'dark')];

        array_walk($toasts, fn (Toast $toast) => $this->toaster->toast($toast));

        $this->view
            ->shouldReceive('with')
            ->twice()
            ->with('_eloquent_ui__toasts', $toasts)
        ;

        $this->composer->compose($this->view);
        $this->composer->compose($this->view);
    }

    public function test_it_handles_large_number_of_toasts(): void
    {
        $toasts = [];
        for ($i = 1; $i <= 100; ++$i) {
            $toasts[] = new Toast(
                "Toast {$i}",
                "Message {$i}",
                ToastTheme::Info,
                true,
                5000,
                'dark',
            );
        }

        array_walk($toasts, fn (Toast $toast) => $this->toaster->toast($toast));

        $this->view
            ->shouldReceive('with')
            ->once()
            ->with('_eloquent_ui__toasts', \Mockery::on(function ($passedToasts) {
                $this->assertCount(100, $passedToasts);

                return true;
            }))
        ;

        $this->composer->compose($this->view);
    }

    public function test_it_preserves_toast_order(): void
    {
        $toasts = [
            new Toast('First', null, ToastTheme::Info, true, 5000, 'dark'),
            new Toast('Second', null, ToastTheme::Success, true, 5000, 'dark'),
            new Toast('Third', null, ToastTheme::Warning, true, 5000, 'dark'),
        ];

        array_walk($toasts, fn (Toast $toast) => $this->toaster->toast($toast));

        $this->view
            ->shouldReceive('with')
            ->once()
            ->with('_eloquent_ui__toasts', \Mockery::on(function ($passedToasts) use ($toasts) {
                $this->assertSame($toasts[0]->title, $passedToasts[0]->title);
                $this->assertSame($toasts[1]->title, $passedToasts[1]->title);
                $this->assertSame($toasts[2]->title, $passedToasts[2]->title);

                return true;
            }));

        $this->composer->compose($this->view);
    }
}
