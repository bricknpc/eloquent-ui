<?php

declare(strict_types=1);

namespace BrickNPC\EloquentUI\Tests\Unit\Http\Traits;

use Illuminate\Http\RedirectResponse;
use PHPUnit\Framework\Attributes\Test;
use BrickNPC\EloquentUI\Tests\TestCase;
use Illuminate\Foundation\Http\FormRequest;
use PHPUnit\Framework\Attributes\CoversTrait;
use BrickNPC\EloquentUI\Http\Traits\CanSubmitAnother;

/**
 * @internal
 */
#[CoversTrait(CanSubmitAnother::class)]
class CanSubmitAnotherTest extends TestCase
{
    #[Test]
    public function it_returns_true_when_submit_another_is_present(): void
    {
        $request = $this->createRequestWithTrait(['submit-another' => '1']);

        $this->assertTrue($request->wantsToSubmitAnother());
    }

    #[Test]
    public function it_returns_false_when_submit_another_is_not_present(): void
    {
        $request = $this->createRequestWithTrait([]);

        $this->assertFalse($request->wantsToSubmitAnother());
    }

    #[Test]
    public function it_redirects_back_with_input_when_submit_another_is_present(): void
    {
        $request = $this->createRequestWithTrait(['submit-another' => '1']);

        $response = $request->redirect('/default');

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(url()->previous(), $response->getTargetUrl());
    }

    #[Test]
    public function it_redirects_to_default_action_when_submit_another_is_not_present(): void
    {
        $request = $this->createRequestWithTrait([]);

        $response = $request->redirect('/default');

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(url('/default'), $response->getTargetUrl());
    }

    #[Test]
    public function it_uses_default_root_path_when_no_default_action_provided(): void
    {
        $request = $this->createRequestWithTrait([]);

        $response = $request->redirect();

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(url('/'), $response->getTargetUrl());
    }

    #[Test]
    public function it_preserves_input_when_redirecting_back(): void
    {
        $inputData = ['name' => 'test', 'email' => 'test@example.com'];
        $request   = $this->createRequestWithTrait(
            array_merge($inputData, ['submit-another' => '1']),
        );

        $response = $request->redirect('/default');

        // Verify the response has input flashed to session
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $flashedInput = $response->getSession()?->get('_old_input');
        $this->assertNotNull($flashedInput);
    }

    /**
     * @return CanSubmitAnother&FormRequest
     */
    private function createRequestWithTrait(array $data = []): FormRequest
    {
        return new class($data) extends FormRequest {
            use CanSubmitAnother;

            private array $testData;

            public function __construct(array $data = [])
            {
                $this->testData = $data;
                parent::__construct();
            }

            public function has($key): bool
            {
                return array_key_exists($key, $this->testData);
            }

            public function input($key = null, $default = null): mixed
            {
                if ($key === null) {
                    return $this->testData;
                }

                return $this->testData[$key] ?? $default;
            }

            public function all($keys = null): array
            {
                return $this->testData;
            }

            public function rules(): array
            {
                return [];
            }
        };
    }
}
