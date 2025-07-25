<?php

namespace App\Livewire;

use App\Services\UtmService;
use Livewire\Component;

class UtmManager extends Component
{
    public bool $enableUtm = false;

    public ?string $utmService = null;

    public ?string $utmSource = null;

    public ?string $utmMedium = null;

    public ?string $utmCampaign = null;

    public ?string $utmTerm = null;

    public ?string $utmContent = null;

    protected $listeners = ['utmDataUpdated'];

    /**
     * Mount the component with initial values.
     */
    public function mount(
        bool $enableUtm = false,
        ?string $utmService = null,
        ?string $utmSource = null,
        ?string $utmMedium = null,
        ?string $utmCampaign = null,
        ?string $utmTerm = null,
        ?string $utmContent = null
    ): void {
        $this->enableUtm = $enableUtm;
        $this->utmService = $utmService;
        $this->utmSource = $utmSource;
        $this->utmMedium = $utmMedium;
        $this->utmCampaign = $utmCampaign;
        $this->utmTerm = $utmTerm;
        $this->utmContent = $utmContent;
    }

    /**
     * Update UTM fields when a popular service is selected.
     */
    public function updatedUtmService(UtmService $utmService): void
    {
        if (empty($this->utmService)) {
            $this->utmSource = null;
            $this->utmMedium = null;
            $this->emitUtmData();

            return;
        }

        $defaults = $utmService->getServiceDefaults($this->utmService);
        if ($defaults) {
            $this->utmSource = $defaults['source'];
            $this->utmMedium = $defaults['medium'];
        }

        $this->emitUtmData();
    }

    /**
     * Handle enable UTM toggle.
     */
    public function updatedEnableUtm(): void
    {
        $this->emitUtmData();
    }

    /**
     * Handle UTM field updates.
     */
    public function updatedUtmSource(): void
    {
        $this->emitUtmData();
    }

    public function updatedUtmMedium(): void
    {
        $this->emitUtmData();
    }

    public function updatedUtmCampaign(): void
    {
        $this->emitUtmData();
    }

    public function updatedUtmTerm(): void
    {
        $this->emitUtmData();
    }

    public function updatedUtmContent(): void
    {
        $this->emitUtmData();
    }

    /**
     * Emit UTM data to parent component.
     */
    private function emitUtmData(): void
    {
        $this->dispatch('utmDataChanged', [
            'enableUtm' => $this->enableUtm,
            'utmService' => $this->utmService,
            'utmSource' => $this->utmSource,
            'utmMedium' => $this->utmMedium,
            'utmCampaign' => $this->utmCampaign,
            'utmTerm' => $this->utmTerm,
            'utmContent' => $this->utmContent,
        ]);
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
        return view('livewire.utm-manager');
    }
}
