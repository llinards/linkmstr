<?php

namespace App\Livewire\Links;

use App\Models\Link;
use App\Services\LinkService;
use App\Services\UtmService;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Attributes\Rule;
use Livewire\Component;

class LinkEditor extends Component
{
    public Link $link;

    #[Rule('required|url|max:2000')]
    public string $originalUrl = '';

    #[Rule('nullable|string|max:255')]
    public ?string $title = null;

    #[Rule('nullable|string|max:1000')]
    public ?string $description = null;

    #[Rule('nullable|date|after:now')]
    public ?string $expiresAt = null;

    #[Rule('nullable|string|max:10|alpha_num')]
    public ?string $customCode = null;

    #[Rule('boolean')]
    public bool $isActive = true;

    // UTM parameters
    public bool $enableUtm = false;

    public ?string $utmService = null;

    public ?string $utmSource = null;

    public ?string $utmMedium = null;

    public ?string $utmCampaign = null;

    public ?string $utmTerm = null;

    public ?string $utmContent = null;

    // Store original URL without UTM parameters for editing
    private ?string $originalUrlWithoutUtm = null;

    /**
     * Mount the component.
     */
    public function mount(Link $link): void
    {
        $this->link = $link;
        $this->originalUrl = $link->original_url;
        $this->title = $link->title;
        $this->description = $link->description;
        $this->expiresAt = $link->expires_at ? $link->expires_at->format('Y-m-d\TH:i') : null;
        $this->customCode = $link->short_code;
        $this->isActive = $link->is_active;

        // Parse existing UTM parameters from the URL
        $this->parseExistingUtmParameters($link->original_url);
    }

    /**
     * Update the link.
     */
    public function updateLink(LinkService $linkService, UtmService $utmService): void
    {
        $this->validate();

        try {
            $url = $this->enableUtm ?
                $this->applyUtmParameters($this->originalUrlWithoutUtm ?? $this->originalUrl, $utmService) :
                $this->originalUrl;

            $linkService->updateLink($this->link, [
                'original_url' => $url,
                'title' => $this->title,
                'description' => $this->description,
                'expires_at' => $this->expiresAt,
                'custom_code' => $this->customCode,
                'is_active' => $this->isActive,
            ]);

            $this->dispatch('link-updated');
            session()->flash('message', 'Link updated successfully.');
        } catch (ValidationException $e) {
            $this->addError('customCode', 'This short code is already taken. Please try another.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->addError('originalUrl', 'An error occurred while updating your link. Please try again.');
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
     * Parse existing UTM parameters from URL.
     */
    private function parseExistingUtmParameters(string $url): void
    {
        $parsedUrl = parse_url($url);

        if (! isset($parsedUrl['query'])) {
            return;
        }

        parse_str($parsedUrl['query'], $queryParams);

        // Check if URL has UTM parameters
        $utmParams = array_filter($queryParams, function ($key) {
            return str_starts_with($key, 'utm_');
        }, ARRAY_FILTER_USE_KEY);

        if (! empty($utmParams)) {
            $this->enableUtm = true;
            $this->utmSource = $queryParams['utm_source'] ?? null;
            $this->utmMedium = $queryParams['utm_medium'] ?? null;
            $this->utmCampaign = $queryParams['utm_campaign'] ?? null;
            $this->utmTerm = $queryParams['utm_term'] ?? null;
            $this->utmContent = $queryParams['utm_content'] ?? null;

            // Store URL without UTM parameters
            $cleanQuery = array_filter($queryParams, function ($key) {
                return ! str_starts_with($key, 'utm_');
            }, ARRAY_FILTER_USE_KEY);

            $this->originalUrlWithoutUtm = $parsedUrl['scheme'].'://'.$parsedUrl['host'].
                (isset($parsedUrl['port']) ? ':'.$parsedUrl['port'] : '').
                ($parsedUrl['path'] ?? '').
                (! empty($cleanQuery) ? '?'.http_build_query($cleanQuery) : '').
                (isset($parsedUrl['fragment']) ? '#'.$parsedUrl['fragment'] : '');
        }
    }

    /**
     * Apply UTM parameters to the URL.
     */
    private function applyUtmParameters(string $url, UtmService $utmService): string
    {
        if ($this->utmService && ! empty($this->utmCampaign)) {
            // Use popular service UTM generation
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

        // Use manual UTM parameters
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
    public function render(): View
    {
        return view('livewire.links.link-editor');
    }
}
