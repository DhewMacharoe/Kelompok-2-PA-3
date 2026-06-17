<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Layanan;
use Illuminate\Support\Facades\DB;

trait ValidatesServiceCombination
{
    /**
     * Validate selected services for package inclusion redundancy and incompatibilities.
     *
     * @param array $serviceIds
     * @return string|null Error message, or null if valid
     */
    protected function validateServiceCombination(array $serviceIds): ?string
    {
        // Filter out null/empty values and get unique IDs
        $serviceIds = array_unique(array_filter($serviceIds));

        if (empty($serviceIds)) {
            return null;
        }

        // Fetch chosen Layanan objects
        $layanans = Layanan::whereIn('id', $serviceIds)->get();

        // Fetch package service mappings directly from DB
        $packageServices = DB::table('package_service')
            ->whereIn('package_id', $serviceIds)
            ->get();

        // 1. Gather all services included in the chosen packages
        $packageServiceIds = [];
        $packagesMap = []; // Maps package_id to array of constituent service IDs
        
        foreach ($packageServices as $row) {
            $packageServiceIds[] = (int) $row->service_id;
            $packagesMap[(int) $row->package_id][] = (int) $row->service_id;
        }

        // 2. Rule BR-02: Check if any chosen single service is already in packageServiceIds
        // Let's find all packages (any package_id in package_service table)
        $allPackages = DB::table('package_service')->pluck('package_id')->unique()->toArray();

        foreach ($layanans as $layanan) {
            // A chosen service is a single service if it is not in $allPackages
            if (!in_array($layanan->id, $allPackages)) {
                if (in_array($layanan->id, $packageServiceIds)) {
                    // Find which package includes it
                    foreach ($packagesMap as $pkgId => $constIds) {
                        if (in_array($layanan->id, $constIds)) {
                            $package = $layanans->firstWhere('id', $pkgId);
                            $packageName = $package ? $package->nama : 'Paket';
                            return 'Layanan "' . $layanan->nama . '" sudah termasuk dalam paket "' . $packageName . '".';
                        }
                    }
                }
            }
        }

        // 3. Rule BR-03: Evaluate incompatibilities
        // Gather all active service IDs (both directly selected and via package constituents)
        $allActiveServiceIds = array_unique(array_merge($serviceIds, $packageServiceIds));

        if (count($allActiveServiceIds) > 1) {
            // Query incompatibilities table
            $incompatibilities = DB::table('incompatibilities')
                ->whereIn('service_id_a', $allActiveServiceIds)
                ->whereIn('service_id_b', $allActiveServiceIds)
                ->get();

            if ($incompatibilities->isNotEmpty()) {
                // Return the first incompatibility message
                return $incompatibilities->first()->deskripsi_konflik;
            }
        }

        return null;
    }
}
