<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'The Glass Pavilion',
                'slug' => 'the-glass-pavilion',
                'short_description' => 'A modern minimalist residential masterpiece featuring cantilevered post-tensioned slabs and panoramic glazing.',
                'description' => 'The Glass Pavilion represents the pinnacle of residential structural engineering. Perched on a steep hillside in Malibu, this multi-tier concrete and glass residence utilizes post-tensioned slabs, subterranean micropiles, and custom thermal-break structural glazing to create an uninterrupted horizon view while achieving rigorous seismic resistance.',
                'client_name' => 'Vanguard Architecture Group',
                'location' => 'Malibu, CA',
                'project_type' => 'Residential',
                'budget_range' => '$4.5M - $6.0M',
                'total_budget' => 4800000.00,
                'expected_revenue' => 5600000.00,
                'received_payment' => 5200000.00,
                'execution_status' => 'Ongoing',
                'is_featured' => true,
                'status' => 'published',
                'is_public' => true,
                'is_public_visible' => true,
                'featured_image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070',
                'gallery' => [
                    'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=2075',
                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?q=80&w=2053',
                    'https://images.unsplash.com/photo-1600566753376-12c8ab7fb75b?q=80&w=2070'
                ],
                'structural_features' => ['Cantilevered Post-Tensioned Slabs', 'Subterranean Micropiling', 'Thermal Structural Glazing'],
                'capabilities' => ['BIM 4D Simulation', 'Structural Dynamic Analysis', 'Precision Geotechnical Anchoring'],
                'project_details' => [
                    'Square Footage' => '6,800 sq ft',
                    'Materials' => 'Glass, Architectural Concrete, Matte Steel',
                    'Timeline' => '18 Months',
                    'Structural Engineer' => 'Arup Structural Solutions',
                    'LEED Status' => 'Gold Certified'
                ],
            ],
            [
                'title' => 'Nexus Office Hub',
                'slug' => 'nexus-office-hub',
                'short_description' => 'Adaptive reuse of a historic warehouse into a 120,000 sq ft modern tech campus with exposed steel atrium.',
                'description' => 'Nexus Office Hub is an expansive commercial renovation that transformed a 1920s brick and steel warehouse into a collaborative high-density corporate headquarters. Incorporating an open sky-lit atrium, seismic retrofitting with carbon fiber composites, and smart HVAC automation, the complex balances heritage character with enterprise energy efficiency.',
                'client_name' => 'Apex Technology Partners',
                'location' => 'Austin, TX',
                'project_type' => 'Commercial',
                'budget_range' => '$12M - $15M',
                'total_budget' => 12500000.00,
                'expected_revenue' => 14800000.00,
                'received_payment' => 14200000.00,
                'execution_status' => 'Completed',
                'is_featured' => true,
                'status' => 'published',
                'is_public' => true,
                'is_public_visible' => true,
                'featured_image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070',
                'gallery' => [
                    'https://images.unsplash.com/photo-1497366811353-6870744d04b2?q=80&w=2069',
                    'https://images.unsplash.com/photo-1497215728101-856f4ea42174?q=80&w=2070',
                    'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2069'
                ],
                'structural_features' => ['Exposed Steel Trusses', 'Carbon Fiber Seismic Wrapping', 'Acoustic Glass Partitions'],
                'capabilities' => ['Historical Preservation', 'LEED Platinum Certification', 'Smart Building IoT Integration'],
                'project_details' => [
                    'Square Footage' => '120,000 sq ft',
                    'Materials' => 'Structural Steel, Reclaimed Brick, Low-E Glass',
                    'Timeline' => '14 Months',
                    'Occupancy Capacity' => '850 Engineers',
                    'Energy Efficiency' => 'Net Zero Ready'
                ],
            ],
            [
                'title' => 'Summit Industrial Park',
                'slug' => 'summit-industrial-park',
                'short_description' => 'State-of-the-art logistics center featuring heavy crane infrastructure and automated distribution zones.',
                'description' => 'Summit Industrial Park is a heavy manufacturing and multimodal logistics facility covering 350,000 square feet. Engineered with ultra-flat laser-screed concrete floors, 42-foot clear ceiling heights, and overhead 25-ton gantry cranes, this development exemplifies industrial durability and high-throughput operational efficiency.',
                'client_name' => 'Pinnacle Global Logistics',
                'location' => 'Chicago, IL',
                'project_type' => 'Industrial',
                'budget_range' => '$18M - $22M',
                'total_budget' => 18500000.00,
                'expected_revenue' => 21500000.00,
                'received_payment' => 16800000.00,
                'execution_status' => 'Ongoing',
                'is_featured' => true,
                'status' => 'published',
                'is_public' => true,
                'is_public_visible' => true,
                'featured_image' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?q=80&w=2070',
                'gallery' => [
                    'https://images.unsplash.com/photo-1504917595217-d4dc5f566fab?q=80&w=2070',
                    'https://images.unsplash.com/photo-1541888946425-d0fbb18086f6?q=80&w=2070',
                    'https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=2070'
                ],
                'structural_features' => ['Laser-Screed Heavy Slab', 'Overhead Gantry Crane Bays', 'High-Clearance Structural Steel'],
                'capabilities' => ['Heavy Load Engineering', 'Multimodal Freight Docking', 'Rooftop Solar Array Integration'],
                'project_details' => [
                    'Square Footage' => '350,000 sq ft',
                    'Materials' => 'Precast Concrete, Structural Steel, Polycarbonate Sky Panels',
                    'Timeline' => '22 Months',
                    'Clear Height' => '42 Feet',
                    'Floor Loading' => '100 kN/m²'
                ],
            ],
            [
                'title' => 'The Horizon Tower',
                'slug' => 'the-horizon-tower',
                'short_description' => 'A 34-story residential high-rise with aerodynamic wind-damping core and panoramic marine vistas.',
                'description' => 'The Horizon Tower rises 34 stories above the Seattle waterfront. Engineered with a tuned mass damper system and high-strength self-consolidating concrete, the skyscraper blends aerodynamic wind mitigation with floor-to-ceiling glass envelopes, offering 240 luxury residential units and four levels of subterranean parking.',
                'client_name' => 'Cascade Metropolitan Development',
                'location' => 'Seattle, WA',
                'project_type' => 'Residential',
                'budget_range' => '$65M - $75M',
                'total_budget' => 68000000.00,
                'expected_revenue' => 78500000.00,
                'received_payment' => 71000000.00,
                'execution_status' => 'Ongoing',
                'is_featured' => true,
                'status' => 'published',
                'is_public' => true,
                'is_public_visible' => true,
                'featured_image' => 'https://images.unsplash.com/photo-1541888946425-d0fbb18086f6?q=80&w=2070',
                'gallery' => [
                    'https://images.unsplash.com/photo-1503387762-592deb58ef4e?q=80&w=2071',
                    'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070',
                    'https://images.unsplash.com/photo-1590381105924-c72589b9ef3f?q=80&w=2071'
                ],
                'structural_features' => ['Tuned Mass Damper', 'Self-Consolidating High-Strength Concrete', 'Unitized Curtain Wall Enclosure'],
                'capabilities' => ['Wind Tunnel Testing', 'Deep Slurry Wall Excavation', 'Tower Crane Logistics Modeling'],
                'project_details' => [
                    'Square Footage' => '480,000 sq ft',
                    'Materials' => 'Reinforced Concrete, Unitized Curtain Wall, Anodized Aluminum',
                    'Timeline' => '32 Months',
                    'Total Floors' => '34 Levels',
                    'Seismic Design Category' => 'Category D'
                ],
            ],
            [
                'title' => 'Eco-Terminal Alpha',
                'slug' => 'eco-terminal-alpha',
                'short_description' => 'Carbon-neutral port logistics facility with geothermal heating and automated intermodal connectivity.',
                'description' => 'Eco-Terminal Alpha is an advanced port logistics and intermodal transfer station engineered for net-zero carbon operations. Built on reclaimed coastal land with deep vibratory stone columns, the facility integrates a 2.5 MW solar microgrid, stormwater bioretention basins, and heavy-duty robotic container transport bays.',
                'client_name' => 'Atlantic Maritime Infrastructure',
                'location' => 'Savannah, GA',
                'project_type' => 'Industrial',
                'budget_range' => '$28M - $35M',
                'total_budget' => 29000000.00,
                'expected_revenue' => 34000000.00,
                'received_payment' => 24500000.00,
                'execution_status' => 'Ongoing',
                'is_featured' => true,
                'status' => 'published',
                'is_public' => true,
                'is_public_visible' => true,
                'featured_image' => 'https://images.unsplash.com/photo-1590381105924-c72589b9ef3f?q=80&w=2071',
                'gallery' => [
                    'https://images.unsplash.com/photo-1581094794329-c8112a89af12?q=80&w=2070',
                    'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=2070',
                    'https://images.unsplash.com/photo-1513694203232-719a280e022f?q=80&w=2069'
                ],
                'structural_features' => ['Vibratory Stone Column Foundation', 'Long-Span Steel Truss Roofs', 'Seawater Resistant Coatings'],
                'capabilities' => ['Net-Zero Microgrid Engineering', 'Coastal Hydrology Analysis', 'Automated Freight Synchronization'],
                'project_details' => [
                    'Square Footage' => '210,000 sq ft',
                    'Materials' => 'Corrosion-Resistant Steel, Low-Carbon Concrete, Composite Decking',
                    'Timeline' => '20 Months',
                    'Solar Generation' => '2.5 MW Microgrid',
                    'Wharf Capacity' => '2 Super-Post-Panamax Berths'
                ],
            ],
            [
                'title' => 'Urban Greenbelt',
                'slug' => 'urban-greenbelt',
                'short_description' => 'Mass timber multi-family residential development integrating passive house thermal performance.',
                'description' => 'Urban Greenbelt is a sustainable residential precinct featuring cross-laminated timber (CLT) framing and living biophilic facades. Designed to meet rigorous Passive House standards, the 140-unit community showcases natural ventilation shafts, prefabricated modular bathroom pods, and high-efficiency thermal insulation envelopes.',
                'client_name' => 'Pacific Eco-Housing Alliance',
                'location' => 'Portland, OR',
                'project_type' => 'Residential',
                'budget_range' => '$16M - $20M',
                'total_budget' => 16500000.00,
                'expected_revenue' => 19200000.00,
                'received_payment' => 18900000.00,
                'execution_status' => 'Completed',
                'is_featured' => true,
                'status' => 'published',
                'is_public' => true,
                'is_public_visible' => true,
                'featured_image' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?q=80&w=2069',
                'gallery' => [
                    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070',
                    'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=2075',
                    'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=2070'
                ],
                'structural_features' => ['Cross-Laminated Timber (CLT) Core', 'Prefabricated Modular Pods', 'Triple-Glazed Argon Windows'],
                'capabilities' => ['Passive House Modeling', 'Carbon Sequestration Tracking', 'Precision Modular Assembly'],
                'project_details' => [
                    'Square Footage' => '165,000 sq ft',
                    'Materials' => 'CLT Mass Timber, Glulam Beams, Recycled Zinc Cladding',
                    'Timeline' => '16 Months',
                    'Embodied Carbon' => '-45% vs Baseline',
                    'Residential Units' => '140 Units'
                ],
            ],
        ];

        foreach ($projects as $project) {
            $slug = Str::slug($project['title']);
            $portfolio = Portfolio::withTrashed()->where('slug', $slug)->first();
            
            if ($portfolio) {
                if ($portfolio->trashed()) {
                    $portfolio->restore();
                }
                $portfolio->update($project);
            } else {
                Portfolio::create($project);
            }
        }
    }
}
