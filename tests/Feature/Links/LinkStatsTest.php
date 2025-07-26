<?php

//
// use App\Livewire\Links\LinkStats;
// use App\Models\Click;
// use App\Models\Link;
// use App\Models\User;
// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Livewire\Livewire;
//
// uses(RefreshDatabase::class);
//
// beforeEach(function () {
//    $this->user = User::factory()->create();
//    $this->link = Link::factory()->create(['user_id' => $this->user->id]);
//    $this->actingAs($this->user);
// });
//
// describe('component initialization', function () {
//    it('mounts with link and loads initial stats', function () {
//        Livewire::test(LinkStats::class, ['link' => $this->link])
//            ->assertSet('link.id', $this->link->id)
//            ->assertSet('period', 'week')
//            ->assertSet('clickData', []);
//    });
//
//    it('loads stats on mount', function () {
//        // Create some clicks for the link
//        Click::factory()->count(3)->create([
//            'link_id' => $this->link->id,
//            'created_at' => now()->subDays(2),
//        ]);
//
//        $component = Livewire::test(LinkStats::class, ['link' => $this->link]);
//
//        expect($component->get('clickData'))->not->toBeEmpty();
//    });
// });
//
// describe('period management', function () {
//    it('changes period successfully', function () {
//        Livewire::test(LinkStats::class, ['link' => $this->link])
//            ->call('changePeriod', 'month')
//            ->assertSet('period', 'month');
//    });
//
//    it('reloads stats when period changes', function () {
//        // Create clicks for different periods
//        Click::factory()->create([
//            'link_id' => $this->link->id,
//            'created_at' => now()->subDays(2), // Within week
//        ]);
//
//        Click::factory()->create([
//            'link_id' => $this->link->id,
//            'created_at' => now()->subDays(20), // Outside week, within month
//        ]);
//
//        $component = Livewire::test(LinkStats::class, ['link' => $this->link]);
//
//        $weekData = $component->get('clickData');
//
//        $component->call('changePeriod', 'month');
//        $monthData = $component->get('clickData');
//
//        expect($monthData)->not->toBe($weekData);
//    });
//
//    it('handles all available periods', function () {
//        $periods = ['day', 'week', 'month', 'year', 'all'];
//
//        foreach ($periods as $period) {
//            Livewire::test(LinkStats::class, ['link' => $this->link])
//                ->call('changePeriod', $period)
//                ->assertSet('period', $period);
//        }
//    });
// });
//
// describe('statistics loading', function () {
//    it('loads stats for day period', function () {
//        Click::factory()->create([
//            'link_id' => $this->link->id,
//            'created_at' => now(),
//        ]);
//
//        Livewire::test(LinkStats::class, ['link' => $this->link])
//            ->call('changePeriod', 'day')
//            ->assertSet('period', 'day');
//    });
//
//    it('aggregates clicks by date', function () {
//        $today = now()->format('Y-m-d');
//        $yesterday = now()->subDay()->format('Y-m-d');
//
//        // Create clicks for today and yesterday
//        Click::factory()->count(3)->create([
//            'link_id' => $this->link->id,
//            'created_at' => now(),
//        ]);
//
//        Click::factory()->count(2)->create([
//            'link_id' => $this->link->id,
//            'created_at' => now()->subDay(),
//        ]);
//
//        $component = Livewire::test(LinkStats::class, ['link' => $this->link]);
//        $clickData = $component->get('clickData');
//
//        expect($clickData[$today])->toBe(3)
//            ->and($clickData[$yesterday])->toBe(2);
//    });
//
//    it('fills empty dates with zero', function () {
//        // Create a click only for today
//        Click::factory()->create([
//            'link_id' => $this->link->id,
//            'created_at' => now(),
//        ]);
//
//        $component = Livewire::test(LinkStats::class, ['link' => $this->link]);
//        $clickData = $component->get('clickData');
//
//        // Should have 7 days of data (week period)
//        expect(count($clickData))->toBe(8); // 7 days + today
//
//        // Yesterday should have 0 clicks
//        $yesterday = now()->subDay()->format('Y-m-d');
//        expect($clickData[$yesterday])->toBe(0);
//    });
//
//    it('handles all period correctly', function () {
//        // Create an old click
//        Click::factory()->create([
//            'link_id' => $this->link->id,
//            'created_at' => now()->subYear(),
//        ]);
//
//        Livewire::test(LinkStats::class, ['link' => $this->link])
//            ->call('changePeriod', 'all')
//            ->assertSet('period', 'all');
//    });
// });
//
// describe('top referrers', function () {
//    it('gets top referrers correctly', function () {
//        // Create clicks with different referrers
//        Click::factory()->count(5)->create([
//            'link_id' => $this->link->id,
//            'referer' => 'https://google.com',
//        ]);
//
//        Click::factory()->count(3)->create([
//            'link_id' => $this->link->id,
//            'referer' => 'https://facebook.com',
//        ]);
//
//        Click::factory()->count(2)->create([
//            'link_id' => $this->link->id,
//            'referer' => 'https://twitter.com',
//        ]);
//
//        $component = Livewire::test(LinkStats::class, ['link' => $this->link]);
//        $topReferrers = $component->instance()->getTopReferrers();
//
//        expect($topReferrers)->toHaveCount(3)
//            ->and($topReferrers->first()->referer)->toBe('https://google.com')
//            ->and($topReferrers->first()->count)->toBe(5);
//    });
//
//    it('limits to top 5 referrers', function () {
//        // Create clicks with 6 different referrers
//        for ($i = 1; $i <= 6; $i++) {
//            Click::factory()->create([
//                'link_id' => $this->link->id,
//                'referer' => "https://site{$i}.com",
//            ]);
//        }
//
//        $component = Livewire::test(LinkStats::class, ['link' => $this->link]);
//        $topReferrers = $component->instance()->getTopReferrers();
//
//        expect($topReferrers)->toHaveCount(5);
//    });
//
//    it('excludes null referrers', function () {
//        Click::factory()->count(3)->create([
//            'link_id' => $this->link->id,
//            'referer' => null,
//        ]);
//
//        Click::factory()->create([
//            'link_id' => $this->link->id,
//            'referer' => 'https://google.com',
//        ]);
//
//        $component = Livewire::test(LinkStats::class, ['link' => $this->link]);
//        $topReferrers = $component->instance()->getTopReferrers();
//
//        expect($topReferrers)->toHaveCount(1)
//            ->and($topReferrers->first()->referer)->toBe('https://google.com');
//    });
// });
//
// describe('rendering', function () {
//    it('renders correctly', function () {
//        Livewire::test(LinkStats::class, ['link' => $this->link])
//            ->assertOk()
//            ->assertViewIs('livewire.links.link-stats');
//    });
//
//    it('passes top referrers to view', function () {
//        Click::factory()->create([
//            'link_id' => $this->link->id,
//            'referer' => 'https://google.com',
//        ]);
//
//        Livewire::test(LinkStats::class, ['link' => $this->link])
//            ->assertViewHas('topReferrers');
//    });
// });
