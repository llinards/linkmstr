<?php

namespace App\Livewire\Links;

use App\Models\Link;
use App\Services\LinkService;
use App\Services\UtmService;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Rule;
use Livewire\Component;

class LinkShortener extends Component
{
    #[Rule('required|url|max:2000')]
    public string $originalUrl = '';

    #[Rule('nullable|string|max:255')]
    public ?string $title = null;

    #[Rule('nullable|string|max:1000')]
    public ?string $description = null;

    #[Rule('nullable|date|after:now')]
    public ?string $expiresAt = null;

    #[Rule('nullable|unique:links,short_code|string|max:10|alpha_num')]
    public ?string $customCode = null;

    public bool $enableUtm = false;

    public ?string $utmService = null;

    public ?string $utmSource = null;

    public ?string $utmMedium = null;

    public ?string $utmCampaign = null;

    public ?string $utmTerm = null;

    public ?string $utmContent = null;

    public ?Link $createdLink = null;

    /**
     * Create a new short link.
     */
    public function createLink(LinkService $linkService, UtmService $utmService): void
    {
        $this->validate();

        try {
            $url = $this->originalUrl;

            if ($this->enableUtm) {
                $url = $this->applyUtmParameters($url, $utmService);
            }

            $this->createdLink = $linkService->createLink([
                'original_url' => $url,
                'title' => $this->title,
                'description' => $this->description,
                'expires_at' => $this->expiresAt,
                'custom_code' => $this->customCode,
            ]);

            session()->flash('message', 'Your link has been shortened!');
            redirect()->route('links.index');
        } catch (ValidationException $e) {
            $this->addError('customCode', 'This short code is already taken. Please try another.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'An error occurred while creating your link. Please try again.');
            $this->addError('originalUrl', 'An error occurred while creating your link. Please try again.');
        }
    }

    /**
     * Update UTM fields when a popular service is selected.
     */
    public function updatedUtmService(UtmService $utmService): void
    {
        if (empty($this->utmService)) {
            $this->utmSource = null;
            $this->utmMedium = null;

            return;
        }

        $defaults = $utmService->getServiceDefaults($this->utmService);
        if ($defaults) {
            $this->utmSource = $defaults['source'];
            $this->utmMedium = $defaults['medium'];
        }
    }

    /**
     * Apply UTM parameters to the URL.
     */
    private function applyUtmParameters(string $url, UtmService $utmService): string
    {
        if ($this->utmService && ! empty($this->utmCampaign)) {
            return $utmService->generatePopularServiceUtm(
                $url,
                $this->utmService,
                $this->utmCampaign,
                array_filter([
                    'utm_term' => $this->utmTerm,
                    'utm_content' => $this->utmContent,
                ])
            );
        }

        $utmParams = array_filter([
            'utm_source' => $this->utmSource,
            'utm_medium' => $this->utmMedium,
            'utm_campaign' => $this->utmCampaign,
            'utm_term' => $this->utmTerm,
            'utm_content' => $this->utmContent,
        ]);

        return $utmService->generateUtmUrl($url, $utmParams);
    }

    /**
     * Get supported services for the dropdown.
     */
    public function getSupportedServicesProperty(): array
    {
        return app(UtmService::class)->getSupportedServices();
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.links.link-shortener');
    }
}
