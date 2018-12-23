<?php
/*
This file is part of SeAT

Copyright (C) 2015, 2017  Leon Jacobs

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

namespace jonlives\Seat\AssetAudit\Http\Controllers;

use jonlives\Seat\AssetAudit\Repositories\Character\Assets;

use Seat\Services\Repositories\Configuration\UserRespository;
use Seat\Web\Http\Controllers\Controller;

/**
 * Class HomeController
 * @package Author\Seat\YourPackage\Http\Controllers
 */
class HomeController extends Controller
{
    use UserRespository;
    use Assets;

    public function getAssetListAndCount(string $user_id, array $asset_ids)
    {
        $assets[0] = $this->getCharacterAssetsByType($user_id, $asset_ids);
        $assets[1] = count($assets[0]);
        return $assets;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getFaxList()
    {
        $fax_asset_ids = array('Apostle' => '37604', 'Dagon' => '42242', 'Lif' => '37606', 'Loggerhead' => '45645', 'Minokawa' => '37605', 'Ninazu' => '37607', 'Venerable' => '42133');
        $groups = $this->getAllGroups();
        foreach($groups as $group)
        {
            foreach($group->users as $user)
            {
                $fax_list = $this->getAssetListAndCount($user->character_id, array_values($fax_asset_ids));
                $user->has_fax = $fax_list[1] > 0;
                $fax_names = array();
                foreach($fax_list[0] as $fax) {
                    array_push($fax_names, $fax['type']['typeName']);
                }

                $user->faxes = implode(', ', $fax_names);
            }
        }

        return view('assetaudit::faxes', compact('groups'));
    }

        /**
     * @return \Illuminate\View\View
     */
    public function getSupercapList()
    {
        $super_asset_ids = array('Aeon' => '23919', 'Hel' => '22852', 'Revenant' => '3514', 'Nyx' => '23913','Vendetta' => '42125','Wyvern' => '23917');
        $titan_asset_ids = array('Avatar' => '11567', 'Erebus' => '671','Komodo' => '45649','Leviathan' => '3764','Molok' => '42241','Vanquisher' => '42126');
        $groups = $this->getAllGroups();
        foreach($groups as $group)
        {
            foreach($group->users as $user)
            {
                $super_list = $this->getAssetListAndCount($user->character_id, array_values($super_asset_ids));
                $user->has_super = $super_list[1] > 0;
                $super_names = array();
                foreach($super_list[0] as $super) {
                    array_push($super_names, $super['type']['typeName']);
                }

                $titan_list = $this->getAssetListAndCount($user->character_id, array_values($titan_asset_ids));
                $user->has_titan = $titan_list[1] > 0;
                $titan_names = array();
                foreach($titan_list[0] as $titan) {
                    array_push($titan_names, $titan['type']['typeName']);
                }

                $user->supers = implode(', ', $super_names);
                $user->titans = implode(', ', $titan_names);
            }
        }

        return view('assetaudit::supers', compact('groups'));
    }
}
