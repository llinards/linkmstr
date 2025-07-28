<?php

namespace App\Livewire\Links;

use App\Models\GeoRule;
use App\Models\Link;
use App\Services\GeoLocationService;
use App\Services\GeoTargetingService;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Rule;
use Livewire\Component;

class GeoRuleManager extends Component
{
    public Link $link;

    public ?int $editingRuleId = null;

    #[Rule('boolean')]
    public bool $enableGeoRules = false;

    #[Rule('nullable|string')]
    public ?string $countryCodesInput = null;

    #[Rule('nullable|string')]
    public ?string $continentCodesInput = null;

    #[Rule('required|url|max:2000')]
    public string $targetUrl = '';

    #[Rule('integer|min:0')]
    public int $priority = 0;

    #[Rule('boolean')]
    public bool $isActive = true;

    public array $countries = [];

    public array $continents = [];

    public array $selectedCountries = [];

    public array $selectedContinents = [];

    public function mount(Link $link, GeoLocationService $geoLocationService)
    {
        $this->link = $link;
        $this->countries = $geoLocationService->getCountries();
        $this->continents = $geoLocationService->getContinents();

        // Auto-enable if there are existing geo rules
        $this->enableGeoRules = $this->link->geoRules()->exists();
    }

    public function createGeoRule(GeoTargetingService $geoTargetingService)
    {
        $this->prepareInputs();

        try {
            $geoTargetingService->createGeoRule($this->link, [
                'country_codes' => $this->countryCodesInput,
                'continent_codes' => $this->continentCodesInput,
                'target_url' => $this->targetUrl,
                'priority' => $this->priority,
                'is_active' => $this->isActive,
            ]);

            $this->resetInputs();
            session()->flash('message', 'Geo targeting rule created successfully.');
        } catch (ValidationException $e) {
            foreach ($e->errors() as $field => $errors) {
                $this->addError($field, $errors[0]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'Failed to create geo targeting rule.');
        }
    }

    public function updateGeoRule(GeoTargetingService $geoTargetingService)
    {
        $this->prepareInputs();

        try {
            $geoRule = GeoRule::findOrFail($this->editingRuleId);

            // Authorization check
            if ($geoRule->link_id !== $this->link->id) {
                throw new \Exception('Unauthorized');
            }

            $geoTargetingService->updateGeoRule($geoRule, [
                'country_codes' => $this->countryCodesInput,
                'continent_codes' => $this->continentCodesInput,
                'target_url' => $this->targetUrl,
                'priority' => $this->priority,
                'is_active' => $this->isActive,
            ]);

            $this->editingRuleId = null;
            $this->resetInputs();
            session()->flash('message', 'Geo targeting rule updated successfully.');
        } catch (ValidationException $e) {
            foreach ($e->errors() as $field => $errors) {
                $this->addError($field, $errors[0]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'Failed to update geo targeting rule.');
        }
    }

    public function editGeoRule(int $id)
    {
        $geoRule = GeoRule::findOrFail($id);

        // Authorization check
        if ($geoRule->link_id !== $this->link->id) {
            session()->flash('error', 'Unauthorized access.');

            return;
        }

        $this->editingRuleId = $geoRule->id;
        $this->countryCodesInput = $geoRule->country_codes;
        $this->continentCodesInput = $geoRule->continent_codes;
        $this->targetUrl = $geoRule->target_url;
        $this->priority = $geoRule->priority;
        $this->isActive = $geoRule->is_active;

        // Set selected countries and continents
        $this->selectedCountries = $geoRule->country_codes ? explode(',', $geoRule->country_codes) : [];
        $this->selectedContinents = $geoRule->continent_codes ? explode(',', $geoRule->continent_codes) : [];
    }

    public function deleteGeoRule(int $id, GeoTargetingService $geoTargetingService)
    {
        try {
            $geoRule = GeoRule::findOrFail($id);

            // Authorization check
            if ($geoRule->link_id !== $this->link->id) {
                throw new \Exception('Unauthorized');
            }

            $geoTargetingService->deleteGeoRule($geoRule);
            session()->flash('message', 'Geo targeting rule deleted successfully.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'Failed to delete geo targeting rule.');
        }
    }

    public function cancelEdit()
    {
        $this->editingRuleId = null;
        $this->resetInputs();
    }

    private function prepareInputs()
    {
        // Convert selected countries array to comma-separated string
        $this->countryCodesInput = ! empty($this->selectedCountries) ? implode(',', $this->selectedCountries) : null;

        // Convert selected continents array to comma-separated string
        $this->continentCodesInput = ! empty($this->selectedContinents) ? implode(',', $this->selectedContinents) : null;
    }

    private function resetInputs()
    {
        $this->countryCodesInput = null;
        $this->continentCodesInput = null;
        $this->targetUrl = '';
        $this->priority = 0;
        $this->isActive = true;
        $this->selectedCountries = [];
        $this->selectedContinents = [];
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.links.geo-rule-manager', [
            'geoRules' => $this->link->geoRules()->orderBy('priority', 'desc')->get(),
        ]);
    }
}
